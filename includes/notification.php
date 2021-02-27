<?php

use Lib\Utils\Message;

$errorMessage = Message::GetMessage('error');
$successMessage = Message::GetMessage('success');
$notifyMessage = Message::GetMessage('notification');

if(isset($errorMessage) && $errorMessage) echo <<<HTML
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error Occured!</strong> {$errorMessage}
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;

if(isset($successMessage) && $successMessage) echo <<<HTML
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {$successMessage}
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;

if(isset($notifyMessage) && $notifyMessage) echo <<<HTML
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Notice!</strong> {$notifyMessage}
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
HTML;