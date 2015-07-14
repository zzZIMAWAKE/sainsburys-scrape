<?php
    include '../vendor/autoload.php';

    use application\controller\ItemListController;

    $itemListController = new ItemListController();
    $itemListController->getItemJson();