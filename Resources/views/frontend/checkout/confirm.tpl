{extends file='parent:frontend/checkout/confirm.tpl'}


{block name='frontend_checkout_confirm_agb'}
    {$smarty.block.parent}
    <li class="block-group row--tos">
        {* Voting checkbox *}
        {block name='frontend_checkout_confirm_voting_checkbox'}
            <span class="block column--checkbox">
                <input type="checkbox"
                       data-ajaxUrl="{url controller='PaulAjaxVoteCheck' action='saveVotingCheckbox' forceSecure}"
                       id="paulVoting"
                       name="paulVoting"
                       data-invalid-tos-jump="true"/>
            </span>
        {/block}

        {* Voting label *}
        {block name='frontend_checkout_confirm_voting_label'}
            <span class="block column--label">
                <label for="paulVoting">{s name="ConfirmVote"}Ich möchte die Produkte bewerten und <b>einmalig</b> eine E-Mail erhalten.{/s}</label>
            </span>
        {/block}
    </li>
{/block}
