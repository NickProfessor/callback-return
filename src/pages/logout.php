<?php

require_once __DIR__ . "/../helpers/SessionManager.php";

SessionManager::destroy();

header("Location: ../../index.php?login-desfeito");