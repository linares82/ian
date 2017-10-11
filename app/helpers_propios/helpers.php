<?php
// My common functions


function cargaMenu($padre)
{
    $menu="";
    $rows=Menu::where('depende_de', $padre)
				->orderBy('orden')->get();
	foreach($rows as $opt){
		$state = has_child($opt->id) ? 'open' : 'close';
		if ($state == 'open'){
                $v="'".$opt->item."', '".route($opt->link)."'"; 				
                    $menu=$menu."<li data-options=\"state:'closed'\"> <span class='dir'> <a class='linktree' href='#' onclick=\"addTab($v)\" target=$opt->target > ".$opt->item."</a></span>";
                    $menu=$menu."<ul>";
                    $menu=$menu.cargaMenu($opt->id);
                    $menu=$menu."</ul>";
				
            }else{   
                    if($opt->permiso_id==""){
                            $v="'".$opt['item']."', '".route($opt->link)."'";
                            $menu=$menu."<li><a class='linktree' href='#' onclick=\"addTab($v)\" target=$opt->target>".$opt->item."</a>";
                    }elseif(Sentry::getUser()->hasAccess($opt->permiso_id)){
                            $v="'".$opt['item']."', '".route($opt->link)."'";
                            $menu=$menu."<li><a class='linktree' href='#' onclick=\"addTab($v)\" target=$opt->target>".$opt->item."</a>";
                    }

            }
                $menu=$menu."</li>";
	}
	return $menu;
}

function has_child($id) {
        $rows = Menu::where('depende_de', $id)->get();
        $registros=0;
        foreach($rows as $r){
            $registros=$registros+1;
        }
        return $registros > 0 ? true : false;
    }
?>