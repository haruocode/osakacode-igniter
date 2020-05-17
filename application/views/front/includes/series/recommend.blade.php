<div class="wrap wrap--dark">
    <div class="container">
        <div class="section">
            <h2 class="Heading--Fancy">
                <span>きっと好きなはず</span>
            </h2>
            <div class="Card-Collection">
                <?php foreach($data_suggest as $course) { ?>
                <div class="Card">
                    <span class="Card__difficulty">
                        <?php echo $course->difficulty==0?"Advanced":($course->difficulty==1?"Beginner":"Intermediate") ?>
                    </span>
                    <div class="Card__image">
                        <a href="{{series_rewrite_url($course)}}">
                            <img src="/images/{{$course->image}}" class="Card__image" alt="{{$course->title}}">
                            <div class="Card__overlay">
                                <i class="material-icons">play_circle_outline</i>
                            </div>
                        </a>
                    </div>
                    <div class="Card__details">
                        <h3 class="Card__title">
                            <a href="{{series_rewrite_url($course)}}">
                                {{$course->title}}
                            </a>
                        </h3>
                        <div class="Card__count">
                            <?php echo sizeof($course->lessons) ?>
                            <span class="utility-muted">
                                動画
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
