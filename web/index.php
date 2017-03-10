<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

$routes = array(

	/* INDEX -------------------------------------------------------------*/
	new Route("/", "MyController::homeAction"),

	/* ADMIN -------------------------------------------------------------*/
	new Route("/dashboard"            , "DashboardController::dashboardShowAction"       ),
	new Route("/dashboard/articles"   , "DashboardController::dashboardArticleShowAction"),
	new Route("/dashboard/article/add", "ArticleController::articleAddAction"             , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/add", "ArticleController::articleAddSubmitAction"       , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/comment"    , "DashboardController::dashboardCommentShowAction"),
	
	/* SITE --------------------------------------------------------------*/
	new Route("/article"       , "ArticleController::articleListAction"     ),
	new Route("/article/add"   , "ArticleController::articleAddAction"       , RequestMethodInterface::METHOD_GET ),
	new Route("/article/add"   , "ArticleController::articleAddSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/article/edit"  , "ArticleController::articleEditAction"      , RequestMethodInterface::METHOD_GET ),
	new Route("/article/edit"  , "ArticleController::articleEditSubmitAction", RequestMethodInterface::METHOD_POST),
	new Route("/article/delete", "ArticleController::articleDeleteAction"   ),


	new Route("/comment"       , "CommentController::commentListAction"     ),
	new Route("/comment/add"   , "CommentController::commentAddAction"       , RequestMethodInterface::METHOD_GET ),
	new Route("/comment/add"   , "CommentController::commentAddSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/comment/edit"  , "CommentController::commentEditAction"      , RequestMethodInterface::METHOD_GET ),
	new Route("/comment/edit"  , "CommentController::commentEditSubmitAction", RequestMethodInterface::METHOD_POST),
	new Route("/comment/delete", "CommentController::commentDeleteAction"   ),
);

$router = new Router($routes);

$router->matchCurrentRequest();
