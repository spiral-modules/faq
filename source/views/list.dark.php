<extends:vault:layout title="[[FAQ]]" class="wide-content"/>
<dark:use path="spiral:listing/*" prefix="listing:"/>

<define:actions>
    <vault:allowed permission="vault.faq.add">
        <vault:uri target="faq:add" icon="add" class="btn waves-effect waves-light">
            [[FAQ]]
        </vault:uri>
    </vault:allowed>
</define:actions>
<?php
/**
 * @var \Spiral\FAQ\Database\FAQ           $entity
 * @var \Spiral\FAQ\VaultServices\Statuses $statuses
 * @var \Spiral\Listing\Listing            $listing
 */
?>
<define:content>
    <vault:card>
        <listing:form listing="<?= $listing ?>">
            <div class="row">
                <div class="col s4">
                    <listing:filter>
                        <form:input name="search" placeholder="[[Find...]]"/>
                    </listing:filter>
                </div>
                <div class="col s2">
                    <listing:filter>
                        <form:select name="status" values="<?= $statuses->labels(true) ?>"/>
                    </listing:filter>
                </div>
                <div class="col s2">
                    <div class="right-align">
                        <listing:reset/>
                    </div>
                </div>
            </div>
        </listing:form>
    </vault:card>

    <vault:listing listing="<?= $listing ?>" as="entity" color="" class="striped">

        <grid:cell label="[[Id:]]" value="<?= $entity->id ?>" sorter="id"/>
        <grid:cell label="[[Question:]]" sorter="question">
            <span title="<?= e($entity->question) ?>"><?= \Spiral\Support\Strings::shorter(e($entity->question), 50) ?></span>
        </grid:cell>
        <grid:cell label="[[Answer:]]">
            <span title="<?= e($entity->answer) ?>"><?= \Spiral\Support\Strings::shorter(e($entity->answer), 100) ?></span>
        </grid:cell>
        <grid:cell label="[[Order:]]" value="<?= $entity->order ?>" sorter="order"/>
        <grid:cell class="right-align">
            <vault:uri target="faq:edit" icon="edit" options="<?= ['id' => $entity->primaryKey()] ?>" class="waves-effect btn-flat"/>
        </grid:cell>

        <grid:cell class="right-align">
            <vault:allowed permission="vault.faq.view">
                <vault:uri target="faq:view" icon="visibility" options="<?= ['id' => $entity->primaryKey()] ?>" class="btn waves-effect"> [[View]]
                </vault:uri>
            </vault:allowed>
        </grid:cell>
    </vault:listing>
</define:content>