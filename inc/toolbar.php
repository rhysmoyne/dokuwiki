<?php
/**
 * Editing toolbar functions
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

if(!defined('DOKU_INC')) die('meh.');

/**
 * Prepares and prints an JavaScript array with all toolbar buttons
 *
 * @emits  TOOLBAR_DEFINE
 * @param  string $varname Name of the JS variable to fill
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function toolbar_JSdefines($varname){
    global $lang;

    $menu = array();

    $evt = new Doku_Event('TOOLBAR_DEFINE', $menu);
    if ($evt->advise_before()){

        // build button array
        $menu = array_merge($menu, array(
           array(
                'type'   => 'format',
                'title'  => $lang['qb_bold'],
                'icon'   => 'bold.png',
                'key'    => 'b',
                'open'   => '**',
                'close'  => '**',
                'block'  => false
                ),
           array(
                'type'   => 'format',
                'title'  => $lang['qb_italic'],
                'icon'   => 'italic.png',
                'key'    => 'i',
                'open'   => '*',
                'close'  => '*',
                'block'  => false
                ),
           array(
                'type'   => 'format',
                'title'  => $lang['qb_code'],
                'icon'   => 'mono.png',
                'key'    => 'm',
                'open'   => "```",
                'close'  => "```",
                'block'  => false
                ),
           array(
                'type'   => 'picker',
                'title'  => $lang['qb_hs'],
                'icon'   => 'h.png',
                'class'  => 'pk_hl',
                'list'   => array(
                               array(
                                    'type'   => 'format',
                                    'title'  => $lang['qb_h1'],
                                    'icon'   => 'h1.png',
                                    'key'    => '1',
                                    'open'   => '# ',
                                    'close'  => '\n',
                                    ),
                               array(
                                    'type'   => 'format',
                                    'title'  => $lang['qb_h2'],
                                    'icon'   => 'h2.png',
                                    'key'    => '2',
                                    'open'   => '## ',
                                    'close'  => '\n',
                                    ),
                               array(
                                    'type'   => 'format',
                                    'title'  => $lang['qb_h3'],
                                    'icon'   => 'h3.png',
                                    'key'    => '3',
                                    'open'   => '### ',
                                    'close'  => '\n',
                                    ),
                               array(
                                    'type'   => 'format',
                                    'title'  => $lang['qb_h4'],
                                    'icon'   => 'h4.png',
                                    'key'    => '4',
                                    'open'   => '#### ',
                                    'close'  => '\n',
                                    ),
                               array(
                                    'type'   => 'format',
                                    'title'  => $lang['qb_h5'],
                                    'icon'   => 'h5.png',
                                    'key'    => '5',
                                    'open'   => '##### ',
                                    'close'  => '\n',
                                    ),
                            ),
                'block'  => true
                ),

           array(
                'type'   => 'linkwiz',
                'title'  => $lang['qb_link'],
                'icon'   => 'link.png',
                'key'    => 'l',
                'open'   => '(',
                'close'  => ')',
                'block'  => false
                ),
           array(
                'type'   => 'format',
                'title'  => $lang['qb_extlink'],
                'icon'   => 'linkextern.png',
                'open'   => '[',
                'close'  => ')',
                'sample' => $lang['qb_extlink'].'](http://example.com',
                'block'  => false
                ),
           array(
                'type'   => 'formatln',
                'title'  => $lang['qb_ol'],
                'icon'   => 'ol.png',
                'open'   => '1. ',
                'close'  => '',
                'key'    => '-',
                'block'  => true
                ),
           array(
                'type'   => 'formatln',
                'title'  => $lang['qb_ul'],
                'icon'   => 'ul.png',
                'open'   => '* ',
                'close'  => '',
                'key'    => '.',
                'block'  => true
                ),
           array(
                'type'   => 'insert',
                'title'  => $lang['qb_hr'],
                'icon'   => 'hr.png',
                'insert' => '\n----\n',
                'block'  => true
                ),
           array(
                'type'   => 'mediapopup',
                'title'  => $lang['qb_media'],
                'icon'   => 'image.png',
                'url'    => 'lib/exe/mediamanager.php?ns=',
                'name'   => 'mediaselect',
                'options'=> 'width=750,height=500,left=20,top=20,scrollbars=yes,resizable=yes',
                'block'  => false
                ),
        ));
    } // end event TOOLBAR_DEFINE default action
    $evt->advise_after();
    unset($evt);

    // use JSON to build the JavaScript array
    $json = new JSON();
    print "var $varname = ".$json->encode($menu).";\n";
}

/**
 * prepares the signature string as configured in the config
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function toolbar_signature(){
    global $conf;
    global $INFO;
    /** @var Input $INPUT */
    global $INPUT;

    $sig = $conf['signature'];
    $sig = dformat(null,$sig);
    $sig = str_replace('@USER@',$INPUT->server->str('REMOTE_USER'),$sig);
    $sig = str_replace('@NAME@',$INFO['userinfo']['name'],$sig);
    $sig = str_replace('@MAIL@',$INFO['userinfo']['mail'],$sig);
    $sig = str_replace('@DATE@',dformat(),$sig);
    $sig = str_replace('\\\\n','\\n',addslashes($sig));
    return $sig;
}

//Setup VIM: ex: et ts=4 :
