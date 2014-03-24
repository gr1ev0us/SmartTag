<?php

/**
 * SmartTag
 *
 * Copyright 2014 by goldsky <goldsky@virtudraft.com>
 *
 * This file is part of SmartTag, a MODX's custom Template Variable for tagging
 *
 * SmartTag is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation version 3.
 *
 * SmartTag is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SmartTag; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package smarttag
 * @subpackage tv
 */
if (!class_exists('SmartTagInputRender')) {

    class SmartTagInputRender extends modTemplateVarInputRender {

        public function __construct(modTemplateVar $tv, array $config = array()) {
            parent::__construct($tv, $config);
            $assetsUrl = $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/smarttag/';
            $this->modx->controller->addJavascript($assetsUrl . 'js/mgr/smarttag.js');
            $connectorUrl = $assetsUrl . 'conn/mgr.php';
            $this->modx->controller->addHTML('
        <script type="text/javascript">
        // <![CDATA[
        SmartTag.config.connectorUrl = "' . $connectorUrl . '";
        // ]]>
        </script>');
        }

        public function getTemplate() {
            return $this->modx->getOption('core_path') . 'components/smarttag/elements/tv/input/tpl/smarttag.tpl';
        }

        /**
         * @param string $value
         * @param array $params
         * @return void|mixed
         */
        public function process($value, array $params = array()) {
            return str_replace('||', ',', $value);
        }

    }

}
return 'SmartTagInputRender';
