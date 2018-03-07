<?php
/**
 * Created by PhpStorm.
 * User: us10140
 * Date: 06.03.2018
 * Time: 12:03
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete a post';
        $auth->add($deletePost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);

//        $auth->addChild($author, $deletePost);
//        $auth->addChild($author, $updatePost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deletePost);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);




        // add the rule
        $rule = new \app\rbac\UserRule;
        $auth->add($rule);

// добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->description = 'Delete own post';
        $deleteOwnPost->ruleName = $rule->name;

        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;

        $auth->add($deleteOwnPost);
        $auth->add($updateOwnPost);

// "updateOwnPost" будет использоваться из "updatePost"
        $auth->addChild($deleteOwnPost, $deletePost);
        $auth->addChild($updateOwnPost, $updatePost);

// разрешаем "автору" обновлять его посты
        $auth->addChild($author, $deleteOwnPost);
        $auth->addChild($author, $updateOwnPost);



        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 17);
        $auth->assign($author, 18);
        $auth->assign($author, 19);
        $auth->assign($author, 20);
    }
}