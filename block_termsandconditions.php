<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 *
 *
 * @package    block
 * @subpackage termsandconditions
 * @copyright  2018 Mihail Pozarski (mihail.pozarski@uai.cl)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_termsandconditions extends block_base {
    //initialize the block
    public function init() {
        $this->title = get_string('title', 'block_termsandconditions');
    }
    
    function instance_allow_multiple() {
        return false;
    }
    
    function instance_allow_config() {
        return false;
    }
    
    function  instance_can_be_hidden() {
        return false;
    }
    
    //Loads the content of the block
    public function get_content() {
        global $OUTPUT, $USER, $COURSE, $DB, $CFG;
        if ($this->content !== null) {
            return $this->content;
        }
        if($this->page->context->contextlevel == CONTEXT_COURSE){
            $configroles = explode(',',get_config('termsandconditions', 'Allow_rol'));
            $view=false;
            if ($roles = get_user_roles($this->page->context, $USER->id)) {
                foreach ($roles as $role) {
                    if(in_array($role->roleid,$configroles)){
                        $view = true;
                        break;
                    }
                }
            }
            if($view || is_siteadmin()){
                if($termsandconditions = $DB->get_record('block_termsandconditions',array("userid"=>$USER->id,"courseid"=>$COURSE->id)) || is_siteadmin()){
                    $content = $OUTPUT->pix_icon("i/completion-auto-pass", "")."politicas de privacidad";
                }else{
                    $content = $OUTPUT->pix_icon("i/completion-auto-fail", "")."politicas de privacidad";
                    $url = $CFG->wwwroot."/blocks/termsandconditions/ajax.php?courseid=$COURSE->id";
                    $content .= "<script>
                                 $( document ).ready(function() {
                                    var text = '<h1> TÉRMINOS Y CONDICIONES </h1>';
    	                                text += ".'"'."<p align = 'justify'> Los presentes términos y condiciones, regulan el acceso y uso de los usuarios a la plataforma Webcursos de la Universidad Adolfo Ibáñez <a href='http://webcursos.uai.cl'>https://webcursos.uai.cl</a>.<br> Los Usuarios deberán de leer y aceptar estas condiciones para usar todos los servicios e informaciones que se facilitan desde la plataforma. El mero acceso y/o utilización de Webcursos, de todos o parte de sus contenidos y/o servicios significa la plena aceptación de las presentes condiciones generales de uso. Para efectos de los presentes términos y condiciones se entenderá por:</p>".'";'.
    	                                "text += ".'"'."<ol type = 'a'>".'";'.
        	                            "text += ".'"'."<li align = 'justify'> Material de Libre Acceso: Son todas aquellas obras que no requieren de alguna suscripción o pago, dentro de estas podemos encontrar artículos de investigación científica de revistas especializadas u otras obras que no requieren de un permiso del autor o de la editorial para su reproducción.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Dominio Público: Son aquellas obras que están libres de todo derecho de propiedad, por ejemplo, por su antigüedad.</li>".'";'.
                                    	"text += ".'"'."<li ali    gn = 'justify'> Catálogo de Obras: Son todas aquellas obras que la Universidad mantiene en su Biblioteca, las cuales se pueden consultar en <a href='http://www.uai.cl/biblioteca'>http://www.uai.cl/biblioteca</a> </li></ol>".'";'.
                                        "text += ".'"'."<b>Condiciones:</b>".'";'.
                                        "text += ".'"'."<ol type = '1' >".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Todo documento o material que sea publicado en Webcursos, deberá dar total cumplimiento a la Ley 17.336 sobre Propiedad Intelectual, de modo que no se incurra en ningún tipo de violación al Derecho de Autor que protege dicha norma legal, ni se transgredan otros derechos consagrados en ésta u otras leyes, situación que deberá ser prevista y revisada por el docente, alumno o persona que provea de información y material a Webcursos.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Los Usuarios deberán abstenerse de publicar cualquier material bibliográfico que no sea de libre acceso, que no sea de dominio público o que no haya sido extraído desde el catálogo de obras disponibles en la Biblioteca de la Universidad Adolfo Ibáñez. Sin perjuicio de lo anterior, este material no podrá extenderse más allá de un 30% del total de la obra (Ejemplo: Si una obra tiene 100 páginas, deberán seleccionarse un máximo de 30 de ellas).</li>'".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Los Usuarios de la plataforma serán responsables por todo el contenido que publiquen en Webcursos, ya sea que éstos se encuentren en foros, documentos adjuntos, avisos o cualquier otro medio de comunicación que permita acceder al contenido protegido por la Ley de Propiedad Intelectual. Los Usuarios deben velar porque dicho contenido se ajuste a la normativa vigente; a los presentes Términos y Condiciones; a la moral, a las buenas costumbres y al orden público.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> La Universidad no será responsable respecto de ningún incumplimiento en que puedan incurrir los Usuarios en el acceso y/o utilización que hagan de Webcursos. Por tanto, el Usuario será personal y exclusivamente responsable de las infracciones contractuales, legales y reglamentarias en las que incurra en relación a los contenidos publicados en Webcursos.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Sin perjuicio de lo anterior, los Administradores de Webcursos de la UAI se reservan el derecho de revisar, sin aviso previo ni expresión de causa, los contenidos publicados por el Usuario y a retirar material en caso que, a juicio exclusivo de los Administradores, sea contrario al ordenamiento jurídico, a estos Términos y Condiciones, a las Políticas de Uso, a la moral y las buenas costumbres, o al orden público.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Los Usuarios que no den cumplimiento a estos Términos y Condiciones, a la normativa vigente, la moral, las buenas costumbres y el orden público durante la utilización de Webcursos, serán responsables personalmente de todos los perjuicios que la UAI y/o terceros puedan sufrir como consecuencia de estos incumplimientos.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Es responsabilidad de cada Usuario conocer la normativa vigente en Chile sobre Propiedad Intelectual, la cual está regulada en la Ley 17.336.</li>".'";'.
                                    	"text += ".'"'."<li align = 'justify'> Los Usuarios deben tener presente que los documentos, obras o materiales disponibles libremente en internet no suponen que éstos sean de dominio público o que no se esté infringiendo derechos de propiedad intelectual.</li>".'";'.
                                        "text += ".'"'."</ol>".'";'.
                                        "text += ".'"'."<h5> <b><input type='checkbox' name='checkacept' id='checkacept' > Acepto los términos anteriormente expuestos <b></h5>".'";'.
                                        "text += ".'"'."<input type='submit' name='submitbutton' value ='Acepto' id='submitbutton' class='btn btn-primary'>".'";'."
                                        $('.page').html(text);
    	                                $('.page').attr('style','padding-left: 20px; padding-right: 20px; margin-left: 0px;');
    	                                $('.site-footer').attr('style','margin-left: 0px; margin-right: 0px;');
    	                                $('.site-menubar').hide();
    	                                $('#toggleMenubar').hide();
    	                                $('#page-course-view-topics').attr('style','background: #f1f4f5');
                                        $('#submitbutton').attr('style','margin-bottom: 5px;');
    	                                
                                        $('#nav-drawer').html('<div></div>');
        	                            $('#submitbutton').click(function() {
                                            if($('#checkacept').prop('checked')){
                                                $.ajax({
                                                    url: '".$url."',
                                                    type: 'json',
                                                    data:{},
                                                    success: function(result){
                                                        window.location.reload();
                                                    },
                                                    error: function(exception) {
                                                        window.location.reload();
                                                    },
                                                });
                                            }else{
                                                alert('Debe aceptar los términos y condiciones para poder utilizar el curso.');
                                            }
                                        });       
                                });
                                </script>";
                }
            }else{
                $content = '';
            }
        }else {
            $content = '';
        }
        $this->content = new stdClass;
        $this->content->text   = $content;
        $this->contentgenerated = true;
        return $this->content;
    }
    //function called inmidiatly after init() used for loads that need to be fast
    //public function specialization() {
    //}
    //test
    function _self_test() {
        return true;
    }
    //tells moodle that the block has global settings
    function has_config() {
        return true;
    }
    //allows to add clases and atributes to the blocks html
    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
        return $attributes;
    }
}