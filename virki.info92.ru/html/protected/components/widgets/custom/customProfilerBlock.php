<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ProfilerBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customProfilerBlock extends CustomWidget
{

    public function run()
    {
        if (DSConfig::getVal('profiler_enable') == 1) {
            $profiling = Profiler::get();
            $this->render(
              'themeBlocks.ProfilerBlock.ProfilerBlock',
              [
                'profiling' => $profiling,
              ]
            );
        }
    }
}
