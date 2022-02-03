<?php

/**
 * Class customBlogs - реализация бизнес-логики работы блогов
 */
class customBlogs
{
    /**
     * @param BlogCommentsBlock $postComment - виджет комментария
     * @param null|int          $uid         - id пользователя
     * @return bool - может ли пользователь создавать комментарий к посту
     */
    public static function allowCreateComment($postComment, $uid = null)
    {
        if (is_object($postComment) && isset($postComment->postCommentsEnabled)) {
            $postCommentsEnabled = $postComment->postCommentsEnabled;
            $postId = $postComment->postId;
            $accessRightsComment = $postComment->accessRightsComment;
        } else {
            $postCommentsEnabled = true;
            $postId = null;
            $accessRightsComment = null;
        }
        //Yii::app()->db->createCommand("select category_id from blog_posts")
        //BlogPosts::model()->findByPk($postId);
        if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')
          || (Yii::app()->user->checkAccess('@allowCreateBlogPostComment')
            && $postCommentsEnabled && self::checkAccessByCategory($accessRightsComment))
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param null|int $uid - id пользователя
     * @return bool - может ли пользователь создавать посты
     */
    public static function allowCreatePost($uid = null)
    {
        if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')
          || (Yii::app()->user->checkAccess('@allowCreateBlogPost')
          )
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param BlogComments $comment - объект комментария к посту
     * @param null|int     $uid     - id пользователя
     * @return bool - может ли пользователь редактировать комментарий
     */
    public static function allowEditComment($comment, $uid = null)
    {
        if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')
          || $comment->uid === Yii::app()->user->id || $comment->uid === $uid
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param BlogPosts $post - объект поста блогов
     * @param null|int  $uid  - id пользователя
     * @return bool - может ли пользователь редактирвоать данный пост
     */
    public static function allowEditPost($post, $uid = null)
    {
        if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')
          || $post->uid === Yii::app()->user->id || $post->uid === $uid
        ) {
            return true;
        } else {
            return false;
        }
    }

// Check Access Yii::app()->user->checkAccess('@manageAnyBlogsContent')
//@allowCreateBlogPost
//@allowCreateBlogPostComment
//

    /**
     * @param string $accessRights - права доступа к категории блогов
     * @return bool - есть ли у текущего пользователя доступ к категории блога
     */
    public static function checkAccessByCategory($accessRights)
    {
        if (!$accessRights) {
            return true;
        }
        if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')) {
            return true;
        }
        $rights = preg_split('/(?:[,;]|^)\s*|\s*(?:[,;]|$)/s', $accessRights);
        if (!$rights || !is_array($rights) || !count($rights)) {
            return true;
        }
        foreach ($rights as $i => $right) {
            if (!trim($right)) {
                unset($rights[$i]);
            } else {
                $rights[$i] = trim($right);
            }
        }
        $rights = array_unique($rights); // SORT_REGULAR SORT_NUMERIC SORT_STRING SORT_LOCALE_STRING
        $role = Yii::app()->user->role;
        if (array_search($role, $rights) !== false || array_search(
            Yii::app()->user->id,
            $rights
          ) !== false || array_search('*', $rights) !== false
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $id - id автора блогов
     * @return null|stdClass - информация об авторе блогов
     */
    public static function getAuthorById($id)
    {
        $res = Yii::app()->db->createCommand(
          "
		SELECT uu.uid, coalesce(uu.fullname,'') AS \"blogName\" FROM users uu
		WHERE uu.uid = :uid
		"
        )->queryRow(true, [':uid' => $id]);
        if ($res) {
            $result = new stdClass();
            $result->uid = $res['uid'];
            $result->authorName = $res['blogName'];
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * @return array - список всех авторов блогов
     */
    public static function getAuthorsArray()
    {
        $res = Yii::app()->db->createCommand(
          "SELECT rr.* from 
		(SELECT uu.uid, coalesce(uu.fullname,'') AS \"blogName\" FROM users uu
		WHERE uu.uid IN (SELECT bp.uid FROM blog_posts bp)) rr
        ORDER BY \"blogName\"
		"
        )->queryAll();
        $result = [];
        if ($res) {
            foreach ($res as $user) {
                $result[$user['uid']] = $user['blogName'];
            }
        }
        return $result;
    }

    /**
     * @param bool $andDisabled - в том числе отключенные категории
     * @return array - список категорий блогов
     */
    public static function getCategoriesArray($andDisabled = true)
    {
        $res = Yii::app()->db->createCommand(
          "
		SELECT cc.id,cc.name, cc.access_rights_post, cc.access_rights_comment FROM blog_categories cc
		WHERE cc.enabled = 1 OR :andDisabled = 1
		ORDER BY cc.name ASC
		"
        )->queryAll(
          true,
          [':andDisabled' => ($andDisabled ? 1 : 0)]
        );
        $result = [];
        if ($res) {
            foreach ($res as $category) {
                if (self::checkAccessByCategory($category['access_rights_post'])) {
                    $result[$category['id']] = $category['name'];
                }
            }
        }
        return $result;
    }

    /**
     * @param int $postId - id поста блогов
     * @return array - список авторов, комментировавших данный пост
     */
    public static function getCommentsAuthorsArray($postId)
    {
        $res = Yii::app()->db->createCommand(
          "SELECT rr.* from (
		SELECT uu.uid, coalesce(uu.fullname,'') AS \"blogName\" FROM users uu
		WHERE uu.uid IN (SELECT bc.uid FROM blog_comments bc WHERE bc.post_id = :postId)) rr
        ORDER BY \"blogName\"
		"
        )->queryAll(true, [':postId' => $postId]);
        $result = [];
        if ($res) {
            foreach ($res as $user) {
                $result[$user['uid']] = $user['blogName'];
            }
        }
        return $result;
    }

    /**
     * @param string $body     - контент блога
     * @param int    $number   - какое изображение п опорядку номеров необходимо получить
     * @param bool   $imgBlock - оборачивать ли изображение в тэг img
     * @return string - строка, содержащая контент изображения из контекста контента блога
     */
    public static function getImageFromBody($body, $number = 0, $imgBlock = false)
    {
        try {
            ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
            ini_set('pcre.recursion_limit', 1024 * 1024);
            if ($imgBlock) {
                $regExp = '/(<img\s.*?\/>)/is';
            } else {
                $regExp = '/<img\s[^<>]*?\s*src\s*=\s*[\'"](.*?)[\'"]/is';
            }
            if (preg_match_all($regExp, $body, $matches)) {
                if (isset($matches[1][$number])) {
                    return $matches[1][$number];
                } else {
                    return '';
                }
            } else {
                return '';
            }
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * @return string - построение элементов sitemap для блогов
     */
    public static function getSitemap()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            return '';
        }
        $result = '';
        return $result;
    }

    /**
     * @param string $body   - контент блога
     * @param int    $length - максимальная длина текста
     * @return mixed|string - подготовленный исходный код контента блога
     */
    public static function prepareBody($body, $length = 0)
    {
        // http://api.html-tidy.org/tidy/quickref_5.1.25.html
        if (extension_loaded('tidy')) {
            $config = [
              'clean'          => 'yes',
              'output-html'    => 'yes',
              'hide-comments'  => 'yes',
              'show-body-only' => true,
            ];
            $tidy = @tidy_parse_string($body, $config, 'utf8');
            if (isset($tidy) && $tidy) {
                $tidy->cleanRepair();
                if (isset($tidy->value) && $tidy->value) {
                    $body = $tidy->value;
                }
            }
        }
        if ($length > 0) {
            ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
            ini_set('pcre.recursion_limit', 1024 * 1024);
            $body = preg_replace('/src\s*=\s*["\']\s*data:.*?["\']/is', 'src=""', $body);
            $path = Yii::getPathOfAlias('application.extensions.simple_html_dom.simple_html_dom') . '.php';
            if (file_exists($path)) {
                include_once($path);
                $Html = @str_get_html($body);
                if ($Html) {
                    $body = $Html->plaintext;
                    if (mb_strlen($body) > $length) {
                        $res = preg_match('/(.{' . $length . ',}?)(?:\s|$)/s', $body, $matches);
                        if ($res) {
                            $body = trim($matches[1]) . '...';
                        }
                    }
                    $Html->clear();
                }
                unset($Html);
            }

        }
        return $body;
    }

    public static function processAllEmbeddedImages()
    {
        $blogPosts = BlogPosts::model()->findAll();
        if ($blogPosts) {
            foreach ($blogPosts as $blogPost) {
                $blogPost->save(false);

            }
        }
        $blogComments = BlogComments::model()->findAll();
        if ($blogComments) {
            foreach ($blogComments as $blogComment) {
                $blogComment->save(false);

            }
        }
    }

    public static function processEmbeddedImages($body)
    {
        ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
        ini_set('pcre.recursion_limit', 1024 * 1024);
        $found = preg_match_all(
          '/\s+src\s*=\s*[\'"]\s*data\s*:\s*image\/(jpg|jpeg|png|gif);\s*base64\s*,\s*(.+?)[\'"]/is',
          $body,
          $matches
        );
        if ($found) {
            foreach ($matches[2] as $i => $match) {
                try {
                    $imgBody = base64_decode($match);
                    $imgFileName = md5($imgBody) . '.' . $matches[1][$i];
                    $imgFileUrl = '/upload/blog/embedded/' . $imgFileName;
                    $imgFilePath = Yii::getPathOfAlias('webroot') . '/upload/blog/embedded';
                    if (!is_dir($imgFilePath)) {
                        @mkdir($imgFilePath, 0777, true);
                    }
                    if (file_exists($imgFilePath)) {
                        if (file_put_contents($imgFilePath . '/' . $imgFileName, $imgBody) !== false) {
                            if (file_exists($imgFilePath . '/' . $imgFileName)) {
                                $body = str_replace($matches[0][$i], " src=\"$imgFileUrl\"", $body);
                            }
                        }
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
        }
        return $body;
    }

}
