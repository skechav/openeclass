<?php

/* ========================================================================
 * Open eClass 
 * E-learning and Course Management System
 * ========================================================================
 * Copyright 2003-2015  Greek Universities Network - GUnet
 * A full copyright notice can be read in "/info/copyright.txt".
 * For a full list of contributors, see "credits.txt".
 *
 * Open eClass is an open platform distributed in the hope that it will
 * be useful (without any warranty), under the terms of the GNU (General
 * Public License) as published by the Free Software Foundation.
 * The full license can be read in "/info/license/license_gpl.txt".
 *
 * Contact address: GUnet Asynchronous eLearning Group,
 *                  Network Operations Center, University of Athens,
 *                  Panepistimiopolis Ilissia, 15784, Athens, Greece
 *                  e-mail: info@openeclass.org
 * ======================================================================== 
 */

require_once 'BasicEvent.php';

class ViewingEvent extends BasicEvent {
    
    const VIDEO_ACTIVITY = 'video';
    const VIDEOLINK_ACTIVITY = 'videolink';
    const EBOOK_ACTIVITY = 'ebook';
    const DOCUMENT_ACTIVITY = 'document';
    const QUESTIONNAIRE_ACTIVITY = 'questionnaire';
    const NEWVIEW = 'resource-viewed';
    
    public function __construct() {
        parent::__construct();
        
        $this->on(self::NEWVIEW, function($data) {
            $this->setEventData($data);
            $this->emit(parent::PREPARERULES);
        });
    }
    
}
