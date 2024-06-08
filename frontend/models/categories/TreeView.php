<?php
namespace frontend\models\categories;

use kartik\base\Lib;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TreeView extends \kartik\tree\TreeView
{
    public function renderTree()
    {
        $structure = $this->_module->treeStructure + $this->_module->dataStructure;
        extract($structure);
        $nodeDepth = $currDepth = $counter = 0;
        $out = Html::beginTag('ul', ['class' => 'kv-tree']) . "\n";
        foreach ($this->_nodes as $node) {
            /**
             * @var Tree $node
             */
            if (!$this->isAdmin && !$node->isVisible() || !$this->showInactive && !$node->isActive()) {
                continue;
            }
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeDepth = $node->$depthAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeLeft = $node->$leftAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeRight = $node->$rightAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeKey = $node->$keyAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeName = $node->$nameAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeIcon = $node->$iconAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeIconType = $node->$iconTypeAttribute;

            $isChild = ($nodeRight == $nodeLeft + 1);
            $indicators = '';

            if (isset($this->nodeLabel)) {
                $label = $this->nodeLabel;
                $nodeName = is_callable($label) ? $label($node) :
                    (is_array($label) ? ArrayHelper::getValue($label, $nodeKey, $nodeName) : $nodeName);
            }
            if ($nodeDepth == $currDepth) {
                if ($counter > 0) {
                    $out .= "</li>\n";
                }
            } elseif ($nodeDepth > $currDepth) {
                $out .= Html::beginTag('ul') . "\n";
                $currDepth = $currDepth + ($nodeDepth - $currDepth);
            } elseif ($nodeDepth < $currDepth) {
                $out .= Lib::str_repeat("</li>\n</ul>", $currDepth - $nodeDepth) . "</li>\n";
                $currDepth = $currDepth - ($currDepth - $nodeDepth);
            }
            if (Lib::trim($indicators) == null) {
                $indicators = '&nbsp;';
            }
            $nodeOptions = [
                'Status'=>$node->Status,
                'data-key' => $nodeKey,
                'data-lft' => $nodeLeft,
                'data-rgt' => $nodeRight,
                'data-lvl' => $nodeDepth,
                'data-disabled' => static::parseBool($node->isDisabled()),
                'data-readonly' => static::parseBool($node->isReadonly()),
                'data-movable-u' => static::parseBool($node->isMovable('u')),
                'data-movable-d' => static::parseBool($node->isMovable('d')),
                'data-movable-l' => static::parseBool($node->isMovable('l')),
                'data-movable-r' => static::parseBool($node->isMovable('r')),
                'data-removable' => static::parseBool($node->isRemovable()),
                'data-removable-all' => static::parseBool($node->isRemovableAll()),
                'data-child-allowed' => static::parseBool($node->isChildAllowed()),
            ];

            $css = [];
            if (!$isChild) {
                $css[] = 'kv-parent ';
            }
            if (!$node->isVisible() && $this->isAdmin) {
                $css[] = 'kv-invisible';
            }
            if ($this->showCheckbox && $node->isSelected()) {
                $css[] = 'kv-selected ';
            }
            if ($node->isCollapsed()) {
                $css[] = 'kv-collapsed ';
            }
            if ($node->isDisabled()) {
                $css[] = 'kv-disabled ';
            }
            if (!$node->isActive()) {
                $css[] = 'kv-inactive ';
            }
            $indicators .= $this->renderToggleIconContainer() . "\n";
            $indicators .= $this->showCheckbox ? $this->renderCheckboxIconContainer() . "\n" : '';
            if (!empty($css)) {
                Html::addCssClass($nodeOptions, $css);
            }
            $out .= Html::beginTag('li', $nodeOptions) . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-tree-list']) . "\n" .
                Html::beginTag('div', ['class' => 'kv-node-indicators']) . "\n" .
                $indicators . "\n" .
                '</div>' . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-node-detail']) . "\n" .
                $this->renderNodeIcon($nodeIcon, $nodeIconType, $isChild) . "\n" .
                Html::tag('span', $nodeName, ['class' => 'kv-node-label']) . "\n" .
                '</div>' . "\n" .
                '</div>' . "\n";
            ++$counter;
        }
        $out .= Lib::str_repeat("</li>\n</ul>", $nodeDepth) . "</li>\n";
        $out .= "</ul>\n";
        if (!$this->hideTopRoot && !$this->topRootAsHeading) {
            $out = $this->renderRoot() . $out;
        }
        return Html::tag('div', $out, $this->treeOptions);
    }
}