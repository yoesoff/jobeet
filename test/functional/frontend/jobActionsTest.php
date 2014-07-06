<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

//$browser->
//  get('/job/index')->
//
//  with('request')->begin()->
//    isParameter('module', 'job')->
//    isParameter('action', 'index')->
//  end()->
//
//  with('response')->begin()->
//    isStatusCode(200)->
//    checkElement('body', '!/This is a temporary page/')->
//  end()
//;

//$browser->info('3 - Post a Job page')->
//  info('  3.1 - Submit a Job')->
// 
//  get('/job/new')->
//  with('request')->begin()->
//    isParameter('module', 'job')->
//    isParameter('action', 'new')->
//  end()->
// 
//  click('Preview your job', array('job' => array(
//    'company'      => 'Sensio Labs',
//    'url'          => 'http://www.sensio.com/',
//    'logo'         => sfConfig::get('sf_upload_dir').'/jobs/sensio-labs.gif',
//    'position'     => 'Developer',
//    'location'     => 'Atlanta, USA',
//    'description'  => 'You will work with symfony to develop websites for our customers.',
//    'how_to_apply' => 'Send me an email',
//    'email'        => 'for.a.job@example.com',
//    'is_public'    => false,
//  )))->
// 
//  with('request')->begin()->
//    isParameter('module', 'job')->
//    isParameter('action', 'create')->
//  end()->
//  with('form')->begin()->
//    hasErrors(false)->
//  end()
//  ->with('form')
//  ->debug();

$browser->
  info('4 - User job history')->
 
  loadData()->
  restart()->
 
  info('  4.1 - When the user access a job, it is added to its history')->
  get('/')->
  click('Web Developer', array(), array('position' => 1))->
  get('/')->
  with('user')->begin()->
    isAttribute('job_history', array($browser->getMostRecentProgrammingJob()->getId()))->
  end()->
 
  info('  4.2 - A job is not added twice in the history')->
  click('Web Developer', array(), array('position' => 1))->
  get('/')->
  with('user')->begin()->
    isAttribute('job_history', array($browser->getMostRecentProgrammingJob()->getId()))->
  end()
;