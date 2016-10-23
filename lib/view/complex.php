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
<div class="page-bar complex">
    <!-- 总记录数 -->
    <a class="page-btn paging-total" href="javascript:;" title="总记录数"><span>共<?php echo $this->totals?>条</span></a>
    <!-- 当前页/总页数 -->
	<a class="page-btn paging-page-num" href="javascript:;" title="当前页/总页数"><span><?php echo $this->page?>/<?php echo $this->lastPage?></span></a>
	
	<!-- 首页 -->
	<a class="page-btn paging-first" href="<?php echo $this->getPageUrl(1)?>"><span>头页</span></a>
		
	<!-- 前页 -->
	<?php if($this->prePage) { ?>
	<a class="page-btn paging-pre" href="<?php echo $this->getPageUrl($this->prePage)?>"><span>上一页</span></a>
	<?php } else { ?>
    <a class="page-btn paging-pre-empty" href="javascript:;"><span>上一页</span></a>
	<?php } ?>
	
	
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
		
	<!-- 后页 -->
	<?php if($this->nextPage) { ?>
	<a class="page-btn paging-next" href="<?php echo $this->getPageUrl($this->nextPage)?>"><span>下一页</span></a>
	<?php } else { ?>
	<a class="page-btn paging-next-empty" href="javascript:;"><span>下一页</span></a>
	<?php } ?>
		
	<!-- 尾页 -->
	<a class="page-btn paging-last" href="<?php echo $this->getPageUrl($this->lastPage)?>"><span>尾页</span></a>
		
	<!-- 每页显示条数 -->
	<span class="paging-rows">每页显示 
	  <select size="1" onchange="window.location=this.value">
	  <?php 
	    for($i = 10; $i <= 100; $i+=10) { 
            $url = $this->getPageUrl(1, $i);
		    if($i == $this->rows) { 
		        echo "<option value=\"{$url}\" selected=\"selected\">{$i}</option>";
		    } else {
		        echo "<option value=\"{$url}\">{$i}</option>";
		    }
	    }
	  ?>
	  </select> 条
	</span>
	
	<span class="paging-goto">跳到第 
	  <select size="1" onchange="window.location=this.value">
	  <?php 
	    for($i=1; $i<=$this->lastPage; $i++) {
			if($i > 1000000) {
				$i += 49999;
			} elseif($i > 100000) {
				$i += 4999;
			} elseif($i > 10000) {
				$i += 499;
			} elseif($i > 1000) {
				$i += 99;
			} elseif($i > 100) {
				$i += 49;
			} elseif($i > 50) {
				$i += 9;
			}
			
			$url = $this->getPageUrl($i);
			if ($i == $this->page) {
			  echo "<option value=\"{$url}\" selected=\"selected\">{$i}</option>\n";
			} else {
			  echo "<option value=\"{$url}\">{$i}</option>\n";
			}
	    } 
	  ?>
	  </select> 页
    </span>
</div>