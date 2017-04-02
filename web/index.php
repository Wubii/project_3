<?php

require_once __DIR__ . "/../autoload.php";

$session = Session::getInstance();

// Affiche le reporting d'erreur
error_reporting(E_ALL);

$routes = array(


	/* INDEX -------------------------------------------------------------*/

	new Route("/"    , "MyController::homeAction", User::ROLE_ANONYMOUS),
	new Route("/test", "MyController::ArticleTest", User::ROLE_ANONYMOUS),


	/* ADMIN -------------------------------------------------------------*/

	new Route("/dashboard"               , "DashboardController::dashboardShowAction"       , User::ROLE_ADMIN),
	new Route("/dashboard/articles"      , "DashboardController::dashboardArticleListAction", User::ROLE_ADMIN),
	new Route("/dashboard/article"       , "DashboardController::dashboardArticleAction"    , User::ROLE_ADMIN),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddAction"            , User::ROLE_ADMIN , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddSubmitAction"      , User::ROLE_ADMIN , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditAction"           , User::ROLE_ADMIN , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditSubmitAction"     , User::ROLE_ADMIN , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/delete", "ArticleController::articleDeleteAction"         , User::ROLE_ADMIN),

	new Route("/dashboard/comments"         , "DashboardController::dashboardCommentAlertListAction"   , User::ROLE_ADMIN),
	new Route("/dashboard/comment/show"     , "DashboardController::dashboardCommentAlertShowAction"   , User::ROLE_ADMIN  ),
	new Route("/dashboard/comment/publish"  , "DashboardController::dashboardCommentAlertPublishAction", User::ROLE_ADMIN),
	new Route("/dashboard/comment/delete"   , "DashboardController::dashboardCommentAlertDeleteAction" , User::ROLE_ADMIN ),
	
	new Route("/dashboard/users"      , "DashboardController::dashboardUserListAction"  , User::ROLE_ADMIN ),
	new Route("/dashboard/user/add"   , "DashboardController::dashboardUserAddAction"   , User::ROLE_ADMIN  , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/user/delete", "DashboardController::dashboardUserDeleteAction", User::ROLE_ADMIN  , RequestMethodInterface::METHOD_POST),
	

	/* SITE --------------------------------------------------------------*/

	new Route("/article"               , "ArticleController::articleAction"                  , User::ROLE_ANONYMOUS),
	new Route("/articles"              , "ArticleController::articleListAction"              , User::ROLE_ANONYMOUS),

	//new Route("/comment"               , "CommentController::commentListAction"              , User::ROLE_),
	new Route("/comment/add-to-article", "CommentController::commentAddToArticleSubmitAction" , User::ROLE_GUEST, RequestMethodInterface::METHOD_POST),
	new Route("/comment/add-to-comment", "CommentController::commentAddToCommentSubmitAction" , User::ROLE_GUEST, RequestMethodInterface::METHOD_POST),
	new Route("/comment/edit"          , "CommentController::commentEditSubmitAction"         , User::ROLE_GUEST, RequestMethodInterface::METHOD_POST),
	new Route("/comment/delete"        , "CommentController::commentDeleteAction"             , User::ROLE_ADMIN, RequestMethodInterface::METHOD_POST),
	new Route("/comment/alert"         , "CommentController::commentAlertAction"              , User::ROLE_ANONYMOUS, RequestMethodInterface::METHOD_POST),

	new Route("/session/register"      , "SessionController::registerAction"                  , User::ROLE_ANONYMOUS),
	new Route("/session/register"      , "SessionController::registerSubmitAction"            , User::ROLE_ANONYMOUS, RequestMethodInterface::METHOD_POST),
	new Route("/session/confirm"       , "SessionController::confirmAction"                   , User::ROLE_ANONYMOUS),
	new Route("/session/login"         , "SessionController::loginAction"                     , User::ROLE_ANONYMOUS),
	new Route("/session/login"         , "SessionController::loginSubmitAction"               , User::ROLE_ANONYMOUS, RequestMethodInterface::METHOD_POST),
	new Route("/session/logout"        , "SessionController::logoutAction"                    , User::ROLE_ANONYMOUS),

);

$router = new Router($routes);

$router->matchCurrentRequest();
