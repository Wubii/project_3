<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

$routes = array(

	/* INDEX -------------------------------------------------------------*/
	new Route("/", "MyController::homeAction"),

	/* ADMIN -------------------------------------------------------------*/
	new Route("/dashboard"               , "DashboardController::dashboardShowAction"       ),
	new Route("/dashboard/articles"      , "DashboardController::dashboardArticleListAction"),
	new Route("/dashboard/article"       , "DashboardController::dashboardArticleAction"    ),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddAction"             , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/add"   , "ArticleController::articleAddSubmitAction"       , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditAction"            , RequestMethodInterface::METHOD_GET ),
	new Route("/dashboard/article/edit"  , "ArticleController::articleEditSubmitAction"      , RequestMethodInterface::METHOD_POST),
	new Route("/dashboard/article/delete", "ArticleController::articleDeleteAction"         ),


	new Route("/dashboard/comments"    , "DashboardController::dashboardCommentListAction"),
	
	/* SITE --------------------------------------------------------------*/
	new Route("/article"       , "ArticleController::articleAction"         ),
	new Route("/articles"      , "ArticleController::articleListAction"     ),


	new Route("/comment"               , "CommentController::commentListAction"              ),
	new Route("/comment/add-to-article", "CommentController::commentAddToArticleSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/comment/add-to-comment", "CommentController::commentAddToCommentSubmitAction" , RequestMethodInterface::METHOD_POST),
	new Route("/comment/edit"          , "CommentController::commentEditSubmitAction"         , RequestMethodInterface::METHOD_POST),
	new Route("/comment/alert"         , "CommentController::commentAlertAction"              , RequestMethodInterface::METHOD_POST),
	new Route("/comment/delete"        , "CommentController::commentDeleteAction"             , RequestMethodInterface::METHOD_POST),
);

$router = new Router($routes);

$router->matchCurrentRequest();
