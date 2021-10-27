<?php

namespace Cakephp3Paginate\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Cakephp3Paginate component
 */
class Cakephp3PaginateComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config)
    {
        $this->Paginator = new \Cake\Datasource\Paginator();
    }

    /**
     * Undocumented function
     *
     * @param \Cake\ORM\Table|\Cake\Orm\Query $query
     */
    public function Cakephp3Paginate($query)
    {
        $query = $this->prepareQueryForCakephp3Paginate($query);

        $queryParams = $this->getController()->getRequest()->getQueryParams();

        if (empty($queryParams['sort'])) {
            $query = $query->order([$this->getController()->getName() . '.id DESC']);
        } else {
            $query = $query->order($queryParams['sort'] . ' ' . $queryParams['direction']);
            unset($queryParams['sort']);
            unset($queryParams['direction']);
        }

        if (isset($queryParams['page'])) {
            unset($queryParams['page']);
        }

        foreach ($queryParams as $key => $queryParam) {
            if (substr($key, 0, 1) == '_') continue;

            if (!is_array($queryParam) && !is_null($queryParam) && $queryParam != '') {
                $query = $this->setCondition($query, $key, $queryParam);
            } else {
                foreach ($queryParam as $keyField => $valueField) {
                    if (is_null($valueField) || $valueField == '') continue;
                    $query = $this->setCondition($query, "{$key}.{$keyField}", $valueField);
                }
            }
        }

        return $this->getController()->Cakephp3Paginate($query);
    }

    public function setCondition($query, $keyField, $valueField)
    {
        $keyArray = explode(' ', $keyField);

        //Date
        if (preg_match('/^\d\d\/\d\d\/\d\d\d\d$/', $valueField)) {
            $date = date_create_from_format('d/m/Y', $valueField);
            $valueField = $date->format('Y-m-d');
            if (count($keyArray) == 2) {
                $keyField = "DATE({$keyArray[0]}) {$keyArray[1]}";
            } else {
                $keyField = "DATE($keyField)";
            }
        } elseif (isset($keyArray[1]) && $keyArray[1] == 'LIKE') {
            $valueField = "%{$valueField}%";
        }

        return $query->where([$keyField => $valueField]);
    }

    /**
     * @param \Cake\ORM\Table|\Cake\Orm\Query $query
     * @return \Cake\Orm\Query
     */
    protected function prepareQueryForCakephp3Paginate($query)
    {
        if ($query instanceof \Cake\ORM\Table) {
            return $query->find();
        }

        return $query;
    }
}
