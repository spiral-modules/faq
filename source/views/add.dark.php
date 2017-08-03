<extends:vault.layout title="[[Add FAQ record]]"/>

<define:actions>
    <vault:uri target="faq" class="btn-flat teal-text waves-effect" post-icon="trending_flat">
        [[BACK]]
    </vault:uri>
</define:actions>

<?php
/**
 * @var \Spiral\FAQ\VaultServices\Statuses $statuses
 */
?>
<define:content>
    <div class="row">
        <div class="col s12 m8">
            <vault:form action="<?= vault()->uri('faq:create') ?>">
                <form:input label="[[Question:]]" name="question"/>
                <form:textarea label="[[Answer:]]" name="answer" rows="20"/>

                <div class="row">
                    <div class="col s12 m6">
                        <form:select label="[[Status:]]" name="status" values="<?= $statuses->labels(true) ?>"/>
                    </div>
                    <div class="col s12 m6">
                        <form:input label="[[Order:]]" name="order"/>
                    </div>
                </div>

                <div class="right-align">
                    <input type="submit" value="[[CREATE]]" class="btn waves-effect waves-light"/>
                </div>
            </vault:form>
        </div>
    </div>
</define:content>