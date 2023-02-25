<?php
/**
 * Created by PhpStorm.
 * User: smaran
 * Date: 3/21/2017
 * Time: 9:44 PM
 */

namespace App\Custom;


class MyModal{

    public static function create($content,$target_elem){
        $id     = ($target_elem['id']) ? $target_elem['id']:null;
        $class  = ($target_elem['class']) ? $target_elem['class']:null;
        $template = '<div aria-hidden="true" role="dialog" id="'.$id.'" class="modal fade '.$class.'">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background:rgba(221,34,255,0.38)">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title text-center">Add new product</h4>
                                </div>
                                <div class="modal-body nav_create_modal_body" style="padding:2% 5%">
                                    <div class="login-wrap">
                                        '.$content.'
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $template;
    }

}