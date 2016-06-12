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

class ModulesEventTest extends \PHPUnit_Framework_TestCase
{
    public function testClassConstantsExists()
    {
        $this->assertTrue(defined('Es\Modules\ModulesEvent::LOAD_MODULES'));
        $this->assertTrue(defined('Es\Modules\ModulesEvent::MERGE_CONFIG'));
        $this->assertTrue(defined('Es\Modules\ModulesEvent::APPLY_CONFIG'));
        $this->assertTrue(defined('Es\Modules\ModulesEvent::BOOTSTRAP'));
    }
}
