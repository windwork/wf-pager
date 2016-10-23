windwork 分页组件
===================

原理，通过设置总记录数和每页显示记录数，计算出分页导航参数并可生成分页导航html。


## 使用案例
```

// $userObj = new \module\user\model\UserModel();
// $total = $userObj->find()->count(); // 总用户数

$total = 125; // 总共记录数
$rows  = 20; // 每页显示记录数
$pager = new \wf\pager\Pager($total, 12);

// 让sql知道从第几行获取数据，获取多少行
// $userObj->find()->all($pager->offset, $pager->rows);

// 显示分页导航条
echo $pager->getHtml();

```

## 分页条显示风格
可以选择使用不同风格显示导航条
- simple  默认简介风格导航
- mobile  使用于手机界面的导航
- complex 复杂导航，一般用在管理后台


### 方式1、在控制器中指定模板风格
```
// 导航选择使用模板
$tpl = 'simple'; // simple|mobile|complex

$pager = new \wf\pager\Pager($total, 12, $tpl);

```

### 方式2、在模板中选择主题风格

当我们视图手机版和电脑版分开的时候，可以在视图中直接调用不同风格的分页导航条以适应不同的客户端。

```
// 控制器中
$pager = new \wf\pager\Pager($total, 10, $tpl);

// PC版视图中使用默认分页导航条
<div>{$pager->getHtml()}</div>

// 手机版视图中使用手机分页导航条
<div>{$pager->getHtml('mobile')}</div>

```

## 分页样式案例
### simple
```


```

### mobile
```

```

### complex
```

```