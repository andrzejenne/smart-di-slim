<?php
namespace BigBIT\SmartDI\Support\slim;

use Psr\Container\ContainerInterface;
use Slim\DefaultServicesProvider;
use Slim\Collection;

/**
 * Class Bootstrap
 * @package BigBIT\SmartDI\Support\slim
 */
class Bootstrap extends \BigBIT\DIBootstrap\Bootstrap {
    public static $defaultSettings = [
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'routerCacheFile' => false,
    ];

    /**
     * @param ContainerInterface $container
     * @param array $bindings
     */
    final protected static function bootContainer(ContainerInterface $container, array $bindings) {
        $userSettings = &$bindings['settings'];

        $bindings['settings'] = function() use ($userSettings) {
            return new Collection(array_merge(static::$defaultSettings, $userSettings));
        };

        parent::bootContainer($container, $bindings);

        $serviceProvider = new DefaultServicesProvider();

        $serviceProvider->register(static::$container);

        $container[DefaultServicesProvider::class] = $serviceProvider;
    }
}
