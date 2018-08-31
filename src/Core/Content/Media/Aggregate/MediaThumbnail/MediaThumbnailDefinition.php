<?php declare(strict_types=1);

namespace Shopware\Core\Content\Media\Aggregate\MediaThumbnail;

use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\Field\BoolField;
use Shopware\Core\Framework\ORM\Field\CreatedAtField;
use Shopware\Core\Framework\ORM\Field\FkField;
use Shopware\Core\Framework\ORM\Field\IdField;
use Shopware\Core\Framework\ORM\Field\IntField;
use Shopware\Core\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\ORM\Field\ReferenceVersionField;
use Shopware\Core\Framework\ORM\Field\StringField;
use Shopware\Core\Framework\ORM\Field\TenantIdField;
use Shopware\Core\Framework\ORM\Field\UpdatedAtField;
use Shopware\Core\Framework\ORM\FieldCollection;
use Shopware\Core\Framework\ORM\Write\Flag\CascadeDelete;
use Shopware\Core\Framework\ORM\Write\Flag\Deferred;
use Shopware\Core\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Core\Framework\ORM\Write\Flag\Required;
use Shopware\Core\Framework\ORM\Write\Flag\WriteProtected;

class MediaThumbnailDefinition extends EntityDefinition
{
    public static function getEntityName(): string
    {
        return 'media_thumbnail';
    }

    public static function defineFields(): FieldCollection
    {
        return new FieldCollection([
            new TenantIdField(),
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),

            (new FkField('media_id', 'mediaId', MediaDefinition::class))->setFlags(new Required()),
            (new ReferenceVersionField(MediaDefinition::class))->setFlags(new Required()),

            new CreatedAtField(),
            new UpdatedAtField(),
            (new IntField('width', 'width'))->setFlags(new Required(), new WriteProtected('write_thumbnails')),
            (new IntField('height', 'height'))->setFlags(new Required(), new WriteProtected('write_thumbnails')),
            (new BoolField('highDpi', 'highDpi'))->setFlags(new Required(), new WriteProtected('write_thumbnails')),
            (new StringField('url', 'url'))->setFlags(new Deferred()),

            (new ManyToOneAssociationField('media', 'media_id', MediaDefinition::class, false))->setFlags(new CascadeDelete()),
        ]);
    }

    public static function getCollectionClass(): string
    {
        return MediaThumbnailCollection::class;
    }

    public static function getStructClass(): string
    {
        return MediaThumbnailStruct::class;
    }
}
