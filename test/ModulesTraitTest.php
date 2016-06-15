<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules\Test;

use Es\Modules\Modules;
use Es\Services\Provider;
use Es\Services\Services;

class ModulesTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'ModulesTraitTemplate.php';
    }

    public function testSetModules()
    {
        $modules  = new Modules();
        $template = new ModulesTraitTemplate();
        $template->setModules($modules);
        $this->assertSame($modules, $template->getModules());
    }

    public function testGetModules()
    {
        $modules  = new Modules();
        $services = new Services();
        $services->set('Modules', $modules);

        Provider::setServices($services);
        $template = new ModulesTraitTemplate();
        $this->assertSame($modules, $template->getModules());
    }
}
