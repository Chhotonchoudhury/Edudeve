<?php

if (!function_exists('getTimelineClass')) {
  function getTimelineClass($activityTypeOrStatus)
  {
    // For activity types
    switch ($activityTypeOrStatus) {
      // For activity status
      case 'Completed':
        return 'success';
      case 'Pending':
        return 'info';
      case 'Cancelled':
        return 'danger';
      default:
        return 'secondary';
    }
  }
}

if (!function_exists('getTimelineIcon')) {
  function getTimelineIcon($activityTypeOrStatus)
  {
    // For activity types
    switch ($activityTypeOrStatus) {
      case 'Call':
        return 'phone';
      case 'Message':
        return 'message';
      case 'Meeting':
        return 'calendar';
      case 'Email':
        return 'envelope';
      case 'Contact':
        return 'user';
    }
  }
}
