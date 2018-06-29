<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Paginator;

/**
 * 分页类
 *
 * @package Delz\PhalconPlus\Paginator
 */
class Pager implements IPager
{
    /**
     * 当前页的索引
     *
     * @var int
     */
    protected $page = 1;

    /**
     * 每页记录数
     *
     * @var int
     */
    protected $pageSize = 20;

    /**
     * 最多显示页数
     *
     * @var int
     */
    protected $maxPages = 10;

    /**
     * 最后一页的索引
     *
     * @var int
     */
    protected $lastPage;

    /**
     * 第一页的索引，默认从 1 开始
     *
     * @var int
     */
    protected $firstPage = 1;

    /**
     * 数据集对象
     *
     * @var IPagerAdapter
     */
    protected $adapter;

    /**
     * 数据集中符合查询条件的记录总数
     *
     * @var int
     */
    protected $totalCount;

    /**
     * 符合条件的记录页数
     *
     * @var int
     */
    protected $pageCount;

    /**
     * 上一页的索引
     *
     * @var int
     */
    protected $prePage;

    /**
     * 上一页的页码
     *
     * @var int
     */
    protected $nextPage;

    /**
     * @param IPagerAdapter $adapter
     */
    public function __construct(IPagerAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->totalCount = $this->adapter->count();
        $this->computingPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getPage():int
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function setPage(int $page)
    {
        $this->page = min(($page > 0 ? $page : $this->getFirstPage()), $this->getLastPage());
        $this->computingPage();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize > 0 ? $pageSize : 1;
        $this->computingPage();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSize():int
    {
        return $this->pageSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxPages(int $maxPages)
    {
        $this->maxPages = (int)$maxPages;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxPages():int
    {
        return $this->maxPages;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrePage():int
    {
        return $this->prePage;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPage():int
    {
        return $this->nextPage;
    }

    /**
     * {@inheritdoc}
     */
    public function isFirstPage():bool
    {
        return $this->page == $this->getFirstPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstPage():int
    {
        return $this->firstPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstPage(int $firstPage)
    {
        $this->firstPage = (int)$firstPage;
        $this->computingPage();
    }

    /**
     * {@inheritdoc}
     */
    public function isLastPage():bool
    {
        return $this->page == $this->getLastPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage():int
    {
        return $this->lastPage;
    }

    /**
     * {@inheritdoc}
     */
    public function isPaginable():bool
    {
        return $this->totalCount > $this->pageSize;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalCount():int
    {
        return $this->totalCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageCount():int
    {
        return $this->pageCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getPages():array
    {
        $tmp = $this->page - floor($this->maxPages / 2);
        $begin = $tmp > $this->getFirstPage() ? $tmp : $this->getFirstPage();
        $end = min($begin + $this->maxPages - 1, $this->getLastPage());
        return range($begin, $end, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function hasResults():bool
    {
        return $this->totalCount > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults()
    {
        return $this->hasResults() ? $this->adapter->getResults(($this->page - $this->firstPage) * $this->pageSize, $this->pageSize) : array();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapter():IPagerAdapter
    {
        return $this->adapter;
    }

    /**
     * 计算各项分页参数
     */
    protected function computingPage()
    {
        $this->pageCount = ceil($this->totalCount / $this->pageSize);
        $this->lastPage = intval($this->pageCount + $this->firstPage - 1);
        $this->prePage = $this->page > $this->getFirstPage() ? $this->page - 1 : $this->getFirstPage();
        $this->nextPage = $this->page < $this->getLastPage() ? $this->page + 1 : $this->getLastPage();
    }
}