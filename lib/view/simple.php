<?php 
// 显示的第1个翻页链接页数
$numFirst = $this->page - 5;
if ($numFirst < 1) {
	$numFirst = 1;
}

// 显示的最后一个翻页链接页数
$numLast = $numFirst + 9;
if ($numLast > $this->lastPage) {
	$numLast = $this->lastPage;
}

if ($numLast < 1) {
	$numLast = 1;
}

if ($numLast - $numFirst < 9) {
	$numFirst = $numLast - 9;
	if ($numFirst < 1) {
		$numFirst = 1;
	}
}
?>
<div class="pager-bar simple">
    <a class="page-btn paging-totals" href="javascript:;"><span>共<?php echo $this->totals ?>条</span></a>
    <a class="page-btn paging-page-num" href="javascript:;" title="当前页/总页数"><span><?php echo $this->page?>/<?php echo $this->lastPage?>页</span></a>
    <!-- 头页 -->
    <a class="page-btn paging-first" href="<?php echo $this->getPageUrl(1) ?>"><span>头页</span></a>
    <!-- /头页 -->
    <!-- 上页 -->
    <?php if($this->prePage):?>
    <a class="page-btn paging-pre" href="<?php echo $this->getPageUrl($this->prePage) ?>"><span>上一页</span></a>
    <?php else: ?>
    <a class="page-btn paging-pre-empty" href="javascript:;"><span>上一页</span></a>
    <?php endif; ?>
    <!-- /上页 -->
  
    <!-- 显示翻页页码 -->
    <?php 
    if ($this->lastPage > 1) {
	    for ($i = $numFirst; $i <= $numLast; $i++) {
			$current = $i == $this->page ? ' current' : '';
			$url = $this->getPageUrl($i);;
			echo "<a class=\"page-btn page-num{$current}\" href=\"{$url}\"><span>{$i}</span></a>";
		}
    }
    ?>
    <!-- /显示翻页页码 -->
  
    <!-- 下一页 -->
    <?php if($this->nextPage):?>
    <a class="page-btn paging-next" href="<?php echo $this->getPageUrl($this->nextPage) ?>"><span>下一页</span></a>
    <?php else: ?>
	<a class="page-btn paging-next-empty" href="javascript:;"><span>下一页</span></a>;
    <?php endif; ?>
    <!-- /下一页 -->
    
    <!-- 尾页 -->
    <a class="page-btn paging-last" href="<?php echo $this->getPageUrl($this->lastPage) ?>"><span>尾页</span></a>
    <!-- /尾页 -->
</div>