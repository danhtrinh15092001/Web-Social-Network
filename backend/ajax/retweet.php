<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['tweetID']) && !empty($_POST['tweetID'])){
            $retweetBy=ht($_POST['retweetBy']);
            $tweetID=ht($_POST['tweetID']);
            $status=$_POST['status'];
            $tweetby=ht($_POST['tweetby']);

            echo $loadFromTweet->retweetCount($retweetBy,$tweetID,$status,$tweetby);
        }

        if (isset($_POST['retweetID']) && !empty($_POST['retweetID'])){
            $retweetBy=ht($_POST['retweetBy']);
            $tweetID=ht($_POST['retweetID']);
            $retweetText="Retweet";
            $retweetClass="content__retweet-it";
            $retweetData=$loadFromTweet->checkRetweet($retweetBy,$tweetID);
            if (!empty($retweetData)){
                if ($retweetData->retweetBy===$retweetBy && $retweetData->retweetFrom===$tweetID)
                {
                    $retweetText="Undo Retweet";
                    $retweetClass="content__retweeted-it";
                }
            }
            echo '<div class="retweet__container-wrapper">
                    <div class="container-wrapper__content">
                        <div data-focusable="true" tabindex="0" class="content__retweet-item '.$retweetClass.'">
                            <div class="retweet__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" weight="20px" height="20px" class="r-p" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
                            </div>
                            <div class="retweet_text">
                                <span class="retweet-no-quote">'.$retweetText.'</span>
                            </div>
                        </div>
                        <div data-focusable="true" tabindex="0" class="content__retweet-item">
                            <div class="retweet__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" class="r-p" viewBox="0 0 24 24" class="r-m0bqgq r-4qtqp9 r-yyyyoo r-1q142lx r-1xvli5t r-zso239 r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M22.132 7.653c0-.6-.234-1.166-.66-1.59l-3.535-3.536c-.85-.85-2.333-.85-3.182 0L3.417 13.865c-.323.323-.538.732-.63 1.25l-.534 5.816c-.02.223.06.442.217.6.14.142.332.22.53.22.023 0 .046 0 .068-.003l5.884-.544c.45-.082.86-.297 1.184-.62l11.337-11.34c.425-.424.66-.99.66-1.59zm-17.954 8.69l3.476 3.476-3.825.35.348-3.826zm5.628 2.447c-.282.283-.777.284-1.06 0L5.21 15.255c-.292-.292-.292-.77 0-1.06l8.398-8.398 4.596 4.596-8.398 8.397zM20.413 8.184l-1.15 1.15-4.595-4.597 1.15-1.15c.14-.14.33-.22.53-.22s.388.08.53.22l3.535 3.536c.142.142.22.33.22.53s-.08.39-.22.53z"/></g></svg>
                            </div>
                            <div class="retweet_text">
                                <span>Quote Tweet</span>
                            </div>
                        </div>
                    </div>
                </div>';

            // echo $loadFromTweet->retweetCount($retweetBy,$tweetID,$status);
        }

        if (isset($_POST['retweetPostID']) && !empty($_POST['retweetPostID'])){
            $retweetBy=ht($_POST['retweetBy']);
            $tweetID=ht($_POST['retweetPostID']);
            $retweetData=$loadFromTweet->checkRetweet($retweetBy,$tweetID);
            if (!empty($retweetData)){
                $loadFromTweet->tweets($retweetBy,5);
            }
            // echo $loadFromTweet->retweetCount($retweetBy,$tweetID,$status);
        }

        // if (isset($_POST['retweetedPostID']) && !empty($_POST['retweetedPostID'])){
        //     $retweetBy=ht($_POST['retweetBy']);
        //     $tweetID=ht($_POST['retweetedPostID']);
        //     $retweetData=$loadFromTweet->checkRetweet($retweetBy,$tweetID);
        //     if (empty($retweetData)){
        //         $loadFromTweet->tweets($retweetBy,5);
        //     }
        //     // echo $loadFromTweet->retweetCount($retweetBy,$tweetID,$status);
        // }
    }
    