<?php

/**
 * job actions.
 *
 * @package    jobeet
 * @subpackage job
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jobActions extends sfActions
{
    
  public function executeIndex(sfWebRequest $request)
  {

//    $this->jobeet_jobs = Doctrine_Core::getTable('JobeetJob')
//      ->createQuery('a')
//      ->execute();
      
//        $q = Doctrine_Query::create()
//        ->from('JobeetJob j')
//        ->where('j.expires_at > ?', date('Y-m-d H:i:s', time()- 86400 * 30));
        
        //->where('j.created_at > ?', date('Y-m-d H:i:s', time() - 86400 * 30)); //30 days ago

        //$this->jobeet_jobs = Doctrine_Core::getTable('JobeetJob')->getActiveJobs();//$q->execute();
      
      $this->categories = Doctrine_Core::getTable('JobeetCategory')->getWithJobs();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new JobeetJobForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
//    $this->forward404Unless($jobeet_job = Doctrine_Core::getTable('JobeetJob')->find(array($request->getParameter('id'))), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));
//    $this->form = new JobeetJobForm($jobeet_job);
      $this->form = new JobeetJobForm($this->getRoute()->getObject());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($jobeet_job = Doctrine_Core::getTable('JobeetJob')->find(array($request->getParameter('id'))), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetJobForm($jobeet_job);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($jobeet_job = Doctrine_Core::getTable('JobeetJob')->find(array($request->getParameter('id'))), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));
    $jobeet_job->delete();

    $this->redirect('job/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $jobeet_job = $form->save();

      $this->redirect('job/edit?id='.$jobeet_job->getId());
    }
  }
  
    public function executePublish(sfWebRequest $request)
    {
      $request->checkCSRFProtection();

      $job = $this->getRoute()->getObject();
      $job->publish();

      $this->getUser()->setFlash('notice', sprintf('Your job is now online for %s days.', sfConfig::get('app_active_days')));

      $this->redirect('job_show_user', $job);
    }
    
    public function executeExtend(sfWebRequest $request)
    {
      $request->checkCSRFProtection();

      $job = $this->getRoute()->getObject();
      $this->forward404Unless($job->extend());

      $this->getUser()->setFlash('notice', sprintf('Your job validity has been extended until %s.', $job->getDateTimeObject('expires_at')->format('m/d/Y')));

      $this->redirect($this->generateUrl('job_show_user', $job));
    }

//    public function executeShow(sfWebRequest $request)
//    {
//      $this->job = $this->getRoute()->getObject();
//
//      // fetch jobs already stored in the job history
//      $jobs = $this->getUser()->getAttribute('job_history', array());
//
//      // add the current job at the beginning of the array
//      array_unshift($jobs, $this->job->getId());
//
//      // store the new job history back into the session
//      $this->getUser()->setAttribute('job_history', $jobs);
//    }

    public function executeShow(sfWebRequest $request)
    {
      $this->jobeet_job = $this->getRoute()->getObject();
      $this->getUser()->addJobToHistory($this->jobeet_job);
    }

    public function executeSearch(sfWebRequest $request)
    {
      $this->forwardUnless($query = $request->getParameter('query'), 'job', 'index');

      $this->jobs = Doctrine_Core::getTable('JobeetJob')->getForLuceneQuery($query);

      if ($request->isXmlHttpRequest())
      {
        if ('*' == $query || !$this->jobs)
        {
          return $this->renderText('No results.');
        }

        return $this->renderPartial('job/list', array('jobs' => $this->jobs));
      }
    }
    
//    public function executeSearch(sfWebRequest $request)
//    {
//      $this->forwardUnless($query = $request->getParameter('query'), 'job', 'index');
//
//      $this->jobs = Doctrine_Core::getTable('JobeetJob') ->getForLuceneQuery($query);
//    }
    
}
