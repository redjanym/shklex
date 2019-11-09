<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class FieldTransactionRepository extends EntityRepository
{
    public function search($modelId)
    {
        $qb = $this->createQueryBuilder("ft");

        $qb->select("ft.id");
        $qb->orderBy("ft.createdAt", "DESC");
        $qb->innerJoin("App\\Entity\\FieldValue", "fv", Join::WITH, "fv.transaction = ft.id");
        $qb->innerJoin("fv.field", "f");
        $qb->where("f.model = :modelId");
        $qb->setParameter("modelId", $modelId);

        return $qb->getQuery();
    }
}