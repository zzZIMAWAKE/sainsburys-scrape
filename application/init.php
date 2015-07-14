<?php
    include '../vendor/autoload.php';
    include 'controller/ItemListController.php';
    include 'model/item.php';

    $itemListController = new ItemListController();
    $itemListController->getItemJson();