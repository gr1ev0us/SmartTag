<?php

class TagsGetListProcessor extends modObjectGetListProcessor {

    public $classKey = 'smarttagTags';
    public $languageTopics = array('smarttag:default');
    public $defaultSortField = 'tag';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'smarttag.TagsGetList';

    /**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $props = $this->getProperties();
        if (isset($props['valuesqry']) &&
                empty($props['valuesqry']) &&
                isset($props['query']) &&
                !empty($props['query'])
        ) {
            $c->where(array(
                'tag:LIKE' => "%{$props['query']}%"
            ));
        }
        // for tagcloud
        if ($props['sort'] === 'count') {
            $c->select(array(
                'smarttagTags.id',
                'smarttagTags.tag',
                'count' => "(SELECT COUNT(*) FROM {$this->modx->getTableName('smarttagTagresources')} AS smarttagTagresources " .
                "WHERE smarttagTagresources.tag_id = smarttagTags.id)"
            ));
            $c->sortby('count', 'desc');
            $c->sortby('tag', 'asc');
        }
        return $c;
    }

    /**
     * Return arrays of objects (with count) converted to JSON.
     *
     * The JSON result includes two main elements, total and results. This format is used for list
     * results.
     *
     * @access public
     * @param array $array An array of data objects.
     * @param mixed $count The total number of objects. Used for pagination.
     * @return string The JSON output.
     */
    public function outputArray(array $array, $count = false) {
        $count = count($array);
        return '{"success":true,"total":' . $count . ',"results":' . $this->modx->toJSON($array) . '}';
    }

}

return 'TagsGetListProcessor';
