<?php
/**
 * Created by PhpStorm.
 * User: nils.langner
 * Date: 19.05.16
 * Time: 09:00
 */

namespace phmLabs\TwigTimeAgoBundle\Twig;

class TimeAgoExtension extends \Twig_Extension
{
    private $firstRun = true;

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time_ago', array($this, 'timeAgo'), array(
                    'is_safe' => array('html'),
                    'needs_environment' => true)
            ));
    }

    public function timeAgo(\Twig_Environment $twig, $date)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        } else if (is_object($date) && $date instanceof \DateTime) {
            $date = $date;
        } else {
            return $date;
        }

        $snippet = $twig->render('@phmLabsTwigTimeAgo/timeago.html.twig', ['firstRun' => $this->firstRun, 'dateIso' => $date->format(\DateTime::ISO8601), 'dateString' => $date->format('y-m-d')]);
        $this->firstRun = false;
        return $snippet;
    }

    public function getName()
    {
        return "time_ago";
    }
}
