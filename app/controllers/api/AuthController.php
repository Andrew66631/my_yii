<?php

namespace app\controllers\api;

use app\models\User;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtKey;
use sizeg\jwt\JwtSigner;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $user = User::findOne(['username' => $username]);

        if (!$user || !$user->validatePassword($password)) {
            Yii::$app->response->statusCode = 401;
            return ['error' => 'Неверные учетные данные'];
        }

        $now = new \DateTimeImmutable();

        $algorithm = Yii::$app->jwt->getSigner(JwtSigner::HS256);

        $key = Yii::$app->jwt->getSignerKey(
            JwtKey::PLAIN_TEXT,
            Yii::$app->jwt->signerKeyContents,
            Yii::$app->jwt->signerKeyPassphrase
        );

        $token = Yii::$app->jwt->getBuilder()
            ->issuedBy('')
            ->permittedFor('')
            ->identifiedBy(uniqid(), true)
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', $user->id)
            ->getToken($algorithm, $key);

        return [
            'token' => $token->toString(),
            'expires' => $token->claims()->get('exp')->getTimestamp(),
            'user_id' => $user->id,
        ];
    }
}