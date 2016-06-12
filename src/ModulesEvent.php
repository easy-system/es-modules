<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules;

use Es\Events\Event;

/**
 * The modules event.
 */
final class ModulesEvent extends Event
{
    /**#@+
     * @const string Event name
     */
    const LOAD_MODULES = 'Modules.Load';
    const MERGE_CONFIG = 'Modules.MergeConfig';
    const APPLY_CONFIG = 'Modules.ApplyConfig';
    const BOOTSTRAP    = 'Modules.Bootstrap';
    /**#@-*/
}
