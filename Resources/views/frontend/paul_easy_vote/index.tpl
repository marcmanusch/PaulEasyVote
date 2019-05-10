{extends file='frontend/index/index.tpl'}

{* Main content *}
{block name='frontend_index_content'}
    <div class="custom-page--content content block">
        <div class="content-paul-easy-vote">
            {block name='frontend_index_content_plugin_summary_vote'}

                {if !$show || $errorOrdernumber || $errorID || $errorOrdernumberNotExists || $errorOrdernumberNotInt}


                        {block name='frontend_index_content_plugin_summary_vote_error'}
                            <div class="alert is--error is--rounded">
                                <div class="alert--icon">
                                    <!-- Alert message icon -->
                                    <i class="icon--element icon--cross"></i>
                                </div>
                                <div class="alert--content">
                                    {if $errorOrdernumberNotInt}
                                        {s name='errorOrdernumberNotInt'}Bitte geben Sie eine gültige Bestellnummer an.{/s}
                                    {elseif $errorOrdernumberNotExists}
                                        {s name='errorOrdernumberNotExists'}Die Bestellnummer existiert nicht!{/s}
                                    {/if}
                                </div>
                            </div>
                        {/block}

                {else}

                    {block name='frontend_index_content_plugin_summary_vote_head'}
                        {s name='SummaryVotes1'}<h1>Hallo, schön das Sie unsere Produkte bewerten möchten ...</h1>{/s}
                        {s name='SummaryVotes2'}
                            <h3>... so helfen Sie uns, unseren Service weiter zu verbessern, und Sie können auf diesem
                                Weg
                                anderen Interessenten direkt Ihre Meinung mitteilen. übrigens, Sie müssen natürlich
                                nicht
                                jeden gekauften Artikel kommentieren, nehmen Sie einfach die wozu Sie Lust haben.</h3>
                        {/s}
                        {s name='SummaryVotes3'}
                            <h3>Folgende gekaufte Artikel könnten von Ihnen bewertet werden:</h3>
                        {/s}
                    {/block}

                    {block name='frontend_index_content_plugin_summary_vote_form'}
                        <form method="post" action="{url module=frontend controller=PaulEasyVote action=validation}">
                            <div class="listing">
                                {foreach from=$order item='sArticles' name='artikel'}
                                    <div class="product--box box--image">
                                        <div class="box--content is--rounded">
                                            <div class="product--info">

                                                {block name='frontend_index_content_plugin_summary_vote_product_info'}
                                                    <a class="product--image" title="{$sArticles.articleName}"
                                                       href="{url controller=detail sArticle=$sArticles.articleID}">

                                                        {block name='frontend_detail_image_default_image_media'}
                                                            <span class="image--media paul-vote">
                                            {block name='frontend_detail_image_default_picture_element'}
                                                <img src="{$sArticles.image.source}" alt="" itemprop="image"
                                                     class="paul-vote-image"/>
                                            {/block}
                                    </span>
                                                        {/block}
                                                    </a>
                                                    <a title="{$sArticles.articleName}" class="product--title"
                                                       href="{url controller=detail sArticle=$sArticles.articleID}">
                                                        {$sArticles.articleName}
                                                    </a>
                                                {/block}

                                                {block name='frontend_index_content_plugin_summary_vote_title'}
                                                    {if $config.showTitle}
                                                        {block name='frontend_index_content_plugin_summary_vote_title_head'}
                                                            <div class="grid_5 third">{s name='SummaryVotesTitleItem'}Bewertungstitel{/s}</div>
                                                        {/block}
                                                        <div class="text">
                                                            <input type="text"
                                                                   name="bewertungstitel{$smarty.foreach.artikel.iteration}"
                                                                   placeholder="{s name='SummaryVotesTitlePlaceholder'}Bewertungstitel{/s}"
                                                                   aria-required="true" class="normal"
                                                                   value="{if $bewertungstitel[$smarty.foreach.artikel.iteration]}{$bewertungstitel[$smarty.foreach.artikel.iteration]}{/if}"/>
                                                        </div>
                                                        <br/>
                                                    {/if}
                                                {/block}

                                                {block name='frontend_index_content_plugin_summary_vote_opinion_head'}
                                                    <div class="grid_5 third">{s name='SummaryVotesText'}Bewertungstext{/s}</div>
                                                {/block}

                                                {block name='frontend_index_content_plugin_summary_vote_opinion'}
                                                    <div class="textarea">
                                                    <textarea name="bewertungstext{$smarty.foreach.artikel.iteration}"
                                                              placeholder="{s name='SummaryVotesTextPlaceholder'}Bewertungstext{/s}"
                                                              aria-required="true"
                                                              class="normal paul-vote">{if $bewertungstext[$smarty.foreach.artikel.iteration]}{$bewertungstext[$smarty.foreach.artikel.iteration]}{/if}</textarea>
                                                    </div>
                                                {/block}

                                                {block name="frontend_index_content_plugin_summary_vote_rating_head"}
                                                    <div class="grid_5 fifth">{s name='SummaryVotesVote'}Bewertung{/s}</div>
                                                {/block}

                                                {block name="frontend_index_content_plugin_summary_vote_rating"}
                                                    <div class="grid_5 sixth">
                                                        <select class="normal"
                                                                name="bewertung{$smarty.foreach.artikel.iteration}">
                                                            <option value=""
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 0}selected="selected" {/if}>{s name='SummaryVotesVoteChoose'}Bitte wählen...{/s}</option>
                                                            <option value="10"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 5}selected="selected" {/if}>{s name='SummaryVotesVote10'}10 sehr gut{/s}</option>
                                                            <option value="9"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 4.5}selected="selected" {/if}>{s name='SummaryVotesVote9'}9{/s}</option>
                                                            <option value="8"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 4}selected="selected" {/if}>{s name='SummaryVotesVote8'}8{/s}</option>
                                                            <option value="7"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 3.5}selected="selected" {/if}>{s name='SummaryVotesVote7'}7{/s}</option>
                                                            <option value="6"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 3}selected="selected" {/if}>{s name='SummaryVotesVote6'}6{/s}</option>
                                                            <option value="5"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 2.5}selected="selected" {/if}>{s name='SummaryVotesVote5'}5{/s}</option>
                                                            <option value="4"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 2}selected="selected" {/if}>{s name='SummaryVotesVote4'}4{/s}</option>
                                                            <option value="3"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 1.5}selected="selected" {/if}>{s name='SummaryVotesVote3'}3{/s}</option>
                                                            <option value="2"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 1}selected="selected" {/if}>{s name='SummaryVotesVote2'}2{/s}</option>
                                                            <option value="1"
                                                                    {if $bewertung[$smarty.foreach.artikel.iteration] == 0.5}selected="selected" {/if}>{s name='SummaryVotesVote1'}1 sehr schlecht{/s}</option>
                                                        </select>
                                                    </div>
                                                {/block}

                                                {block name='frontend_index_content_plugin_summary_vote_article_hidden_fields'}
                                                    <input type="hidden" value="{$sArticles.articleID}"
                                                           name="articleID{$smarty.foreach.artikel.iteration}"/>
                                                {/block}

                                            </div>
                                        </div>
                                    </div>
                                    {block name='frontend_index_content_plugin_summary_vote_order_hidden_fields'}
                                        <input type="hidden" value="{$smarty.foreach.artikel.iteration}" name="anzahl"/>
                                        <input type="hidden" value="{$sArticles.ordernumber}" name="ordernumber"/>
                                        <input type="hidden" value="{$Shop->getId()}" name="shopID"/>
                                        <input type="hidden" value="{$bestellnummer}" name="bestellnummer"/>
                                    {/block}

                                {/foreach}
                            </div>

                            {block name='frontend_index_content_plugin_summary_vote_button'}
                                <button value="submit" name="Submit" type="submit"
                                        class="btn is--primary is--full is--center">{s name='SummaryVotesSaveButton'}Speichern{/s}</button>
                            {/block}

                        </form>
                    {/block}
                {/if}

            {/block}
        </div>
    </div>
{/block}


{* Sidebar right *}
{block name='frontend_index_sidebar'}{/block}