
<?php
    $schema    = new \geomify\Schema\Schema();
    $input     = new \geomify\Processor\Input();    
?>
<div class="gtab-holder">
    <div class="gtab-header">
        <div class="header-item">
            <h2>Video tutorials</h2>
            <p>Watch our Tutorials and learn mroe about GEOMIFY and our licensing options</p>
        </div>
    </div>
    <div class="gtab-toolbar">
        <div class="tutorials-search-box">
            <select name="tutorials-search" id="tutorials-search">
                <?php $input::__array2options( $schema::get( 'packages' ), '- Choose license type -' )?>
            </select>
            <div class="filter-tutorials">Filter</div>
        </div>
    </div>

    <div class="gtab-body">
        <div class="geomify-tutorials-list-holder">
            <?php include 'list.php'; ?>
        </div>
    </div>
</div>