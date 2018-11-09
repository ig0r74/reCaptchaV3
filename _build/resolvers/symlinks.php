<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/reCaptchaV3/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/recaptchav3')) {
            $cache->deleteTree(
                $dev . 'assets/components/recaptchav3/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/recaptchav3/', $dev . 'assets/components/recaptchav3');
        }
        if (!is_link($dev . 'core/components/recaptchav3')) {
            $cache->deleteTree(
                $dev . 'core/components/recaptchav3/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/recaptchav3/', $dev . 'core/components/recaptchav3');
        }
    }
}

return true;