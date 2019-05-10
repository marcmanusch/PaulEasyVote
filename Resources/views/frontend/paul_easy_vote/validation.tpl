{extends file='frontend/index/index.tpl'}

{* Main content *}
{block name='frontend_index_content'}

    <div class="custom-page--content content block">
        <div class="content-ott-summary-votes">


            <div class="alert is--success is--rounded">
                <div class="alert--icon">
                    <!-- Alert message icon -->
                    <i class="icon--element icon--check"></i>
                </div>
                <div class="alert--content">
                    {s name='HeadlineSummaryVotesValidation'}Vielen Dank für Ihre Bewertung.{/s}
                </div>
            </div>

            <h1>{s name='HeadlineSummaryVotesValidation'}Vielen Dank für Ihre Bewertung.{/s}</h1>
            <p>
                {s name='HeadlineSummaryVotesValidationText'}Ihre Bewertung wird sobald diese von uns geprüft wurde freigegeben.{/s}
            <p/>


        </div>
    </div>
{/block}

{* Sidebar right *}
{block name='frontend_index_sidebar'}{/block}