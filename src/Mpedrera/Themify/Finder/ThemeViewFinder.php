<?php namespace Mpedrera\Themify\Finder;

use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class ThemeViewFinder extends FileViewFinder {

    /**
     * Location of the last theme added to paths.
     *
     * @var string $prevLocation
     */
    protected $prevLocation;

    /**
     * Priority that the last theme had when set.
     *
     * @var int prevPriority
     */
    protected $prevPriority;

    /**
     * Prepend a location to the finder paths, instead of 
     * appending. This way, theme views have priority.
     *
     * @param string $location
     * @param int $priority Priority of the setter method in reverse order
     * @return void
     */
    public function addThemeLocation($location, $priority)
    {
        // Make changes only if the priority number is lower
        if ($this->prevPriority === null || $priority < $this->prevPriority) {
            // If present, remove old location from $paths
            // If not, prepend it to $paths
            if (($pos = $this->hasPreviousThemeLocation()) !== false) {
                array_splice($this->paths, $pos, 1, $location);
            } else {
                array_unshift($this->paths, $location);
            }

            $this->prevLocation = $location;
            $this->prevPriority = $priority;
        }        
    }

     /**
     * Check if a previous theme location has been added to $paths.
     *
     * @return int|false Returns index of the $location if found, false if not
     */
    protected function hasPreviousThemeLocation()
    {
        if ($this->prevLocation === null) {
            return false;
        }

        return array_search($this->prevLocation, $this->paths));
    }

}