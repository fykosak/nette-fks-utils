<?php

namespace Fykosak\Utils\ORM;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * @author Michal Koutný <xm.koutny@gmail.com>
 */
abstract class AbstractModel extends ActiveRow {
    public function __construct(array $data, Selection $table) {
        parent::__construct($data, $table);
    }

    public static function createFromActiveRow(ActiveRow $row): self {
        if ($row instanceof static) {
            return $row;
        }
        return new static($row->toArray(), $row->getTable());
    }
}
