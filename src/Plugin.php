<?php
declare(strict_types=1);

namespace MixerApi\Rest;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Rest\Command as Commands;
use MixerApi\Rest\Lib\ResponseStatusCodeModifier;

/**
 * Class Plugin
 *
 * @package App
 */
class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected ?string $name = 'MixerApi/Rest';

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected bool $middlewareEnabled = false;

    /**
     * Register container services
     *
     * @var bool
     */
    protected bool $servicesEnabled = false;

    /**
     * Plugin options.
     *
     * @var array
     */
    private array $options = [
        'crud' => [
            'statusCodes' => [
                'index' => 200,
                'view' => 200,
                'add' => 201,
                'edit' => 200,
                'delete' => 204,
            ],
        ],
    ];

    /**
     * Load routes or not
     *
     * @var bool
     */
    protected bool $routesEnabled = false;

    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app); // TODO: Change the autogenerated stub
        if (Configure::check('MixerApi.Rest')) {
            $this->options = Configure::read('MixerApi.Rest');
        }
        (new ResponseStatusCodeModifier())->listen($this->options['crud']['statusCodes']);
    }

    /**
     * @inheritDoc
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('mixerapi:rest route list', Commands\ListRoutesCommand::class);
        $commands->add('mixerapi:rest route create', Commands\CreateRoutesCommand::class);

        return $commands;
    }
}
