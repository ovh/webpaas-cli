<?php
declare(strict_types=1);
/**
 * @file
 * This is the index.php script for automated OVH staging CLI builds.
 */

use Platformsh\Cli\Service\Config;

require '../cli/vendor/autoload.php';
$config = new Config();
$appName = $config->get('application.name');

$version = getenv('CLI_VERSION', true);

$pharUrl = getenv('CLI_URL_PATH', true) ?: 'pstaging.phar';
$pharHash = hash_file('sha256', __DIR__ . '/' . ltrim(getenv('CLI_URL_PATH', true), '/'));
if ($timestamp = getenv('CLI_BUILD_DATE', true)) {
    $pharDate = date('c', is_int($timestamp) ? $timestamp : strtotime($timestamp));
} else {
    $pharDate = false;
}

$baseUrl = 'https://' . $_SERVER['HTTP_HOST'];

$installScript = sprintf(
  'curl -sfS %s | php',
  $baseUrl . '/installer'
);
if (strpos($version, '-') !== false) {
    $installScript .= ' -- --dev';
}

$revertScript = '';
if ($config->has('application.installer_url')) {
    $revertScript = sprintf(
        'curl -sfS %s | php',
        $config->get('application.installer_url')
    );
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($appName) ?> | dev build</title>
    <style>
        html {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 300;
            background-color: #fff;
        }

        h1 {
            font-weight: 100;
        }
        h2 {
            font-weight: 400;
        }
        h1, h2 {
            text-align: center;
        }
        h1 a {
            color: inherit !important;
            text-decoration: none !important;
        }

        body {
            max-width: 40em;
            margin: 3em auto;
        }

        p {
            word-break: break-all;
        }

        img {
            display: block;
            margin: 10px auto;
        }

        code {
            font-family: "Courier New", Courier, monospace;
        }
        .code-block {
            display: block;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <img
        src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MCA1MCI+PGRlZnM+PHN0eWxlPi5lOTE1NmI3ZC1iZjE4LTQ2OWItOWVhZi02NDQwYzhiMDY2ZDd7ZmlsbDojZmZmO30uYTBhZjE0OWEtZjU5NC00ZTkyLWIyMTItYzk4MmY2OGM5OTExe2ZpbGw6IzBhMGEwYTt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPlBsYXRmb3Jtc2hfaWNvbl9ibGFjazwvdGl0bGU+PGcgaWQ9ImIzZmU0MjhmLWM1ZmYtNGUxNi05NjZmLWQxMzI2NWJhNThjMCIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iYWEzYTQzODMtZjc3OC00YThlLWExZmQtNWVkYjYzYTE4MzIzIiBkYXRhLW5hbWU9IkxheWVyIDEiPjxyZWN0IGNsYXNzPSJlOTE1NmI3ZC1iZjE4LTQ2OWItOWVhZi02NDQwYzhiMDY2ZDciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIvPjxyZWN0IGNsYXNzPSJhMGFmMTQ5YS1mNTk0LTRlOTItYjIxMi1jOTgyZjY4Yzk5MTEiIHg9IjEwLjM2IiB5PSIxMS4xIiB3aWR0aD0iMjguNTUiIGhlaWdodD0iMTEuMzUiLz48cmVjdCBjbGFzcz0iYTBhZjE0OWEtZjU5NC00ZTkyLWIyMTItYzk4MmY2OGM5OTExIiB4PSIxMC4zNiIgeT0iMzUuNzkiIHdpZHRoPSIyOC41NSIgaGVpZ2h0PSIzLjg2Ii8+PHJlY3QgY2xhc3M9ImEwYWYxNDlhLWY1OTQtNGU5Mi1iMjEyLWM5ODJmNjhjOTkxMSIgeD0iMTAuMzYiIHk9IjI2LjExIiB3aWR0aD0iMjguNTUiIGhlaWdodD0iNS44MiIvPjwvZz48L2c+PC9zdmc+"
        alt=""
        width="120"
        height="120">

    <h1><?= htmlspecialchars($appName) ?></h1>

    <?php if ($pharUrl): ?>
        <p>
            Download: <a href="<?= htmlspecialchars($pharUrl) ?>"><?= htmlspecialchars($pharUrl) ?></a>
        </p>
    <?php endif; ?>
    <?php if ($pharDate): ?>
        <p>
            Build date: <code><?= htmlspecialchars($pharDate) ?></code>
        </p>
    <?php endif; ?>
    <?php if ($pharHash): ?>
        <p>
            SHA-256 hash: <code><?= htmlspecialchars($pharHash) ?></code>
        </p>
    <?php endif; ?>
    <?php if ($version): ?>
        <p>
            Version: <code><?= htmlspecialchars($version) ?></code>
        </p>
    <?php endif; ?>
    <?php if ($installScript): ?>
        <h3>Installation instructions</h3>
        <p>
            Install this version with:<br/>
            <code class="code-block"><?= htmlspecialchars($installScript) ?></code>
        </p>
    <?php endif; ?>

</body>
</html>
