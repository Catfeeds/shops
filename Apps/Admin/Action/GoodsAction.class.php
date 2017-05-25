<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 *   * ADD BY YANG
 * ============================================================================
 * 商品控制器
 */
class GoodsAction extends BaseAction{

   /**
	 * 查看
     */
	public function toView(){
		$this->isLogin();
		$this->checkPrivelege('splb_00');
		$m = D('Admin/Goods');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
		}else{
			die("商品不存在!");
		}
		$this->view->display('/goods/view');
	}
    /**
	 * 查看
	 */
	public function toPenddingView(){
		$this->isLogin();
		$this->checkPrivelege('spsh_00');
		$m = D('Admin/Goods');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
			//获取商品分类信息
			$m = D('Admin/GoodsCats');
			$this->assign('goodsCatsList',$m->queryByList());
			//获取商家商品分类
			$m = D('Admin/ShopsCats');
			$this->assign('shopCatsList',$m->queryByList($object['shopId'],0));
		}else{
			die("商品不存在!");
		}
		$this->view->display('/goods/view_pendding');
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('splb_00');
		//获取地区信息
		$m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0));
		//获取商品分类信息
		$m = D('Admin/GoodsCats');
		$this->assign('goodsCatsList',$m->queryByList());
		$m = D('Admin/Goods');
    	$page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize'],I());// 实例化分页类 传入总记录数和每页显示的记录数
    	$page['pager'] = $pager->show();

        $score = (int)I('score',0)?1:0;
        $miaos = (int)I('miaos',0)?1:0;
        $pintuan = (int)I('pintuan',0)?1:0;
    	$this->assign('Page',$page);
    	$this->assign('shopName',I('shopName'));
    	$this->assign('goodsName',I('goodsName'));
    	$this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0));
    	$this->assign('goodsCatId1',I('goodsCatId1',0));
    	$this->assign('goodsCatId2',I('goodsCatId2',0));
    	$this->assign('goodsCatId3',I('goodsCatId3',0));
    	$this->assign('isAdminBest',I('isAdminBest',-1));
    	$this->assign('isAdminRecom',I('isAdminRecom',-1));
        $this->assign('pintuan', $pintuan); $this->assign('score', $score); $this->assign('miaos', $miaos);
        $this->display("/goods/list");
	}
    /**
	 * 分页查询
	 */
	public function queryPenddingByPage(){
		$this->isLogin();
		$this->checkPrivelege('spsh_00');
		//获取地区信息
		$m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0));
		//获取商品分类信息
		$m = D('Admin/GoodsCats');
		$this->assign('goodsCatsList',$m->queryByList());
		$m = D('Admin/Goods');
    	$page = $m->queryPenddingByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize'],I());// 实例化分页类 传入总记录数和每页显示的记录数
    	$pager->setConfig('header','个会员');
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
    	$this->assign('shopName',I('shopName'));
    	$this->assign('goodsName',I('goodsName'));
    	$this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0));
    	$this->assign('goodsCatId1',I('goodsCatId1',0));
    	$this->assign('goodsCatId2',I('goodsCatId2',0));
    	$this->assign('goodsCatId3',I('goodsCatId3',0));
        $this->display("/goods/list_pendding");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	$this->isLogin();
		$m = D('Admin/Goods');
		$list = $m->queryByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 列表查询[获取启用的区域信息]
	 */
    public function queryShowByList(){
    	$this->isLogin();
		$m = D('Admin/Goods');
		$list = $m->queryShowByList();
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
	/**
	 * 修改待审核商品状态
	 */
	public function changePenddingGoodsStatus(){
		$this->isLogin();
		$this->checkPrivelege('spsh_04');
		$m = D('Admin/Goods');
		$rs = $m->changeGoodsStatus();
		$this->ajaxReturn($rs);
	}
    /**
	 * 修改商品状态
	 */
	public function changeGoodsStatus(){
		$this->isLogin();
		$this->checkPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeGoodsStatus();
		$this->ajaxReturn($rs);
	}
	public function becheChangeGoodsStatus(){
		$this->isLogin();
		$this->checkPrivelege('splb_04');
		$id = I('post.id');
	}

    /**
	 * 获取待审核的商品数量
	 */
	public function queryPenddingGoodsNum(){
		$this->isLogin();
    	$m = D('Admin/Goods');
    	$rs = $m->queryPenddingGoodsNum();
    	$this->ajaxReturn($rs);
	}
    /**
	 * 批量设置精品
	 */
	public function changeBestStatus(){
		$this->isLogin();
		$this->checkPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeBestStatus();
		$this->ajaxReturn($rs);
	}
    /**
	 * 批量设置推荐
	 */
	public function changeRecomStatus(){
		$this->isLogin();
		$this->checkPrivelege('splb_04');
		$m = D('Admin/Goods');
		$rs = $m->changeRecomStatus();
		$this->ajaxReturn($rs);
	}

    /**
     * ADD BY YANG
     * 新增、编辑商品
     */
    public function toEdit(){
        $this->isLogin();
        $USER = session('WST_USER');
        //获取商品分类信息
        $m = D('Home/GoodsCats');
        $this->assign('goodsCatsList',$m->queryByList());
        $sm = D('Home/ShopsCats');
        $pkShopCats = $sm->getCatAndChild($USER['shopId']);
        $this->assign('pkShopCats',$pkShopCats);
        //获取商家商品分类
//        $m = D('Home/ShopsCats');
//        $this->assign('shopCatsList',$m->queryByList($USER['shopId'],0));
        //获取商品类型
        $m = D('Home/AttributeCats');
        $this->assign('attributeCatsCatsList',$m->queryByList());
        $m = D('Admin/Goods');
        $object = array();
        $goodsId = (int)I('id',0);
        if($goodsId>0){
            $object = $m->get();
            $packages = $m->getGoodsPackages($goodsId);
            $this->assign('packages',$packages);
        }else{
            $object = $m->getModel();
        }

        $this->assign('object',$object);
        $this->assign("umark",I('umark'));
        $this->display("goods/edit");
    }

	
};
?>