<div class="pager-bar mobile">
	<!-- 头页 -->
    <a class="page-btn paging-first" href="<?php $this->getPageUrl(1)?>"><span>头页</span></a>
		
	<!-- 前页 -->
	<?php if($this->prePage) { ?>
	<a class="page-btn paging-pre" href="<?php $this->getPageUrl($this->prePage)?>"><span>上一页</span></a>
	<?php } else { ?>
	<a class="page-btn paging-pre-empty" href="javascript:;"><span>上一页</span></a>
	<?php } ?>
	
	<!-- 当前页/总页数 -->
	<a class="page-btn paging-page-num" href="javascript:;" title="当前页/总页数"><span><?php echo $this->page?>/<?php echo $this->lastPage?></span></a>
		
	<!-- 后页 -->
	<?php if($this->nextPage) { ?>
	<a class="page-btn paging-next" href="<?php echo $this->getPageUrl($this->nextPage)?>"><span>下一页</span></a>
	<?php } else { ?>
	<a class="page-btn paging-next-empty" href="javascript:;"><span>下一页</span></a>
	<?php } ?>
		
	<!-- 尾页 -->
	<a class="page-btn paging-last" href="<?php echo $this->getPageUrl($this->lastPage)?>"><span>尾页</span></a>
</div>