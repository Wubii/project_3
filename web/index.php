<?php

require_once __DIR__ . "/../autoload.php";

$session = Session::getInstance();

// Affiche le reporting d'erreur
error_reporting(E_ALL);

$routes = array(


	/* INDEX -------------------------------------------------------------*/

	new Route("/"    , "MyController::homeAction"),
	new Route("/test", "MyController::testAction"),


	/* ADMIN -------------------------------------------------------------*/

	new Route("/dashboard"               , "DashboardController::dashboardShowAction"          ),
	new Route("/dashboard/articles"      , "DashboardController::dashboardArticleListAction"   ),
	new Route("/dashboard/article"       , "DashboardController::dashboardArticleAction"       ),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddAction"                , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddSubmitAction"          , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditAction"               , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditSubmitAction"         , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/delete", "ArticleController::articleDeleteAction"            ),

	new Route("/dashboard/comments"         , "DashboardController::dashboardCommentAlertListAction"   ),
	new Route("/dashboard/comment/show"     , "DashboardController::dashboardCommentAlertShowAction"   ),
	new Route("/dashboard/comment/publish"  , "DashboardController::dashboardCommentAlertPublishAction"),
	new Route("/dashboard/comment/delete"   , "DashboardController::dashboardCommentAlertDeleteAction" ),
	
	new Route("/dashboard/users"      , "DashboardController::dashboardUserListAction" ),
	new Route("/dashboard/user/add"   , "DashboardController::dashboardUserAddAction"   , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/user/delete", "DashboardController::dashboardUserDeleteAction", RequestMethodInterface::METHOD_POST),
	

	/* SITE --------------------------------------------------------------*/

	new Route("/article"               , "ArticleController::articleAction"                  ),
	new Route("/articles"              , "ArticleController::articleListAction"              ),

	new Route("/comment"               , "CommentController::commentListAction"              ),
	new Route("/comment/add-to-article", "CommentController::commentAddToArticleSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/comment/add-to-comment", "CommentController::commentAddToCommentSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/comment/edit"          , "CommentController::commentEditSubmitAction"         , RequestMethodInterface::METHOD_POST),
	new Route("/comment/delete"        , "CommentController::commentDeleteAction"             , RequestMethodInterface::METHOD_POST),
	new Route("/comment/alert"         , "CommentController::commentAlertAction"              , RequestMethodInterface::METHOD_POST),

	new Route("/session/register"      , "SessionController::registerAction"                  ),
	new Route("/session/register"      , "SessionController::registerSubmitAction"             , RequestMethodInterface::METHOD_POST),
	new Route("/session/confirm"       , "SessionController::confirmAction"                   ),
	new Route("/session/login"         , "SessionController::loginAction"                     ),
	new Route("/session/login"         , "SessionController::loginSubmitAction"                , RequestMethodInterface::METHOD_POST),
	new Route("/session/logout"        , "SessionController::logoutAction"                    ),

);

$router = new Router($routes);

$router->matchCurrentRequest();
