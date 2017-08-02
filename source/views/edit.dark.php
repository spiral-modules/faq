<extends:vault.layout title="[[Edit FAQ record]]"/>

<define:actions>
    <vault:uri target="faq" class="btn-flat waves-effect" post-icon="trending_flat">
        [[BACK]]
    </vault:uri>
</define:actions>
<?php
/**
 * @var \Spiral\FAQ\Database\FAQ $entity
 */
?>
<define:content>
    <div class="row">
        <div class="col s12 m8">
            <vault:form action="<?= vault()->uri('faq:update', ['id' => $entity->primaryKey()]) ?>">
                <div class="row">
                    <div class="col s12 m12">
                        <form:input label="[[Question:]]" name="question" value="<?= e($entity->question) ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <form:textarea label="[[Answer:]]" name="answer" rows="20" value="<?= $entity->answer ?>"/>
                    </div>
                </div>
                <form:select label="[[Status:]]" name="status" values="<?= $statuses->labels(true) ?>" value="<?= $entity->status ?>"/>

                <div class="right-align">
                    <input type="submit" value="[[UPDATE]]" class="btn waves-effect waves-light"/>
                </div>
            </vault:form>
        </div>
        <div class="col s12 m4">
            <vault:block>
                <dl>
                    <dt>[[ID:]]</dt>
                    <dd><?= $entity->primaryKey() ?></dd>
                    <dt>[[Time Created:]]</dt>
                    <dd><?= $entity->time_created ?></dd>
                    <dt>[[Time Updated:]]</dt>
                    <dd><?= $entity->time_updated ?></dd>
                </dl>
            </vault:block>
        </div>
    </div>
</define:content>