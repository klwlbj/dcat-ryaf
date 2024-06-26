<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection check_type
     * @property Grid\Column|Collection total_score
     * @property Grid\Column|Collection order_by
     * @property Grid\Column|Collection difficulty
     * @property Grid\Column|Collection rectify_content
     * @property Grid\Column|Collection check_method
     * @property Grid\Column|Collection check_result_uuid
     * @property Grid\Column|Collection question
     * @property Grid\Column|Collection rectify
     * @property Grid\Column|Collection check_standard_id
     * @property Grid\Column|Collection check_question_id
     * @property Grid\Column|Collection firm_id
     * @property Grid\Column|Collection report_code
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection check_result
     * @property Grid\Column|Collection total_point
     * @property Grid\Column|Collection deduction_point
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection file_name
     * @property Grid\Column|Collection file_path
     * @property Grid\Column|Collection file_extension
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection system_item_id
     * @property Grid\Column|Collection community_name
     * @property Grid\Column|Collection custom_number
     * @property Grid\Column|Collection head_man
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection floor
     * @property Grid\Column|Collection area_quantity
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection pictures
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection expires_at
     * @property Grid\Column|Collection area_id
     * @property Grid\Column|Collection check_unit
     * @property Grid\Column|Collection notification_title
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection job_info
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection check_type(string $label = null)
     * @method Grid\Column|Collection total_score(string $label = null)
     * @method Grid\Column|Collection order_by(string $label = null)
     * @method Grid\Column|Collection difficulty(string $label = null)
     * @method Grid\Column|Collection rectify_content(string $label = null)
     * @method Grid\Column|Collection check_method(string $label = null)
     * @method Grid\Column|Collection check_result_uuid(string $label = null)
     * @method Grid\Column|Collection question(string $label = null)
     * @method Grid\Column|Collection rectify(string $label = null)
     * @method Grid\Column|Collection check_standard_id(string $label = null)
     * @method Grid\Column|Collection check_question_id(string $label = null)
     * @method Grid\Column|Collection firm_id(string $label = null)
     * @method Grid\Column|Collection report_code(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection check_result(string $label = null)
     * @method Grid\Column|Collection total_point(string $label = null)
     * @method Grid\Column|Collection deduction_point(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection file_name(string $label = null)
     * @method Grid\Column|Collection file_path(string $label = null)
     * @method Grid\Column|Collection file_extension(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection system_item_id(string $label = null)
     * @method Grid\Column|Collection community_name(string $label = null)
     * @method Grid\Column|Collection custom_number(string $label = null)
     * @method Grid\Column|Collection head_man(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection floor(string $label = null)
     * @method Grid\Column|Collection area_quantity(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection pictures(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection expires_at(string $label = null)
     * @method Grid\Column|Collection area_id(string $label = null)
     * @method Grid\Column|Collection check_unit(string $label = null)
     * @method Grid\Column|Collection notification_title(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection job_info(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection check_type
     * @property Show\Field|Collection total_score
     * @property Show\Field|Collection order_by
     * @property Show\Field|Collection difficulty
     * @property Show\Field|Collection rectify_content
     * @property Show\Field|Collection check_method
     * @property Show\Field|Collection check_result_uuid
     * @property Show\Field|Collection question
     * @property Show\Field|Collection rectify
     * @property Show\Field|Collection check_standard_id
     * @property Show\Field|Collection check_question_id
     * @property Show\Field|Collection firm_id
     * @property Show\Field|Collection report_code
     * @property Show\Field|Collection status
     * @property Show\Field|Collection check_result
     * @property Show\Field|Collection total_point
     * @property Show\Field|Collection deduction_point
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection file_name
     * @property Show\Field|Collection file_path
     * @property Show\Field|Collection file_extension
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection system_item_id
     * @property Show\Field|Collection community_name
     * @property Show\Field|Collection custom_number
     * @property Show\Field|Collection head_man
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection address
     * @property Show\Field|Collection floor
     * @property Show\Field|Collection area_quantity
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection pictures
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection expires_at
     * @property Show\Field|Collection area_id
     * @property Show\Field|Collection check_unit
     * @property Show\Field|Collection notification_title
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection job_info
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection check_type(string $label = null)
     * @method Show\Field|Collection total_score(string $label = null)
     * @method Show\Field|Collection order_by(string $label = null)
     * @method Show\Field|Collection difficulty(string $label = null)
     * @method Show\Field|Collection rectify_content(string $label = null)
     * @method Show\Field|Collection check_method(string $label = null)
     * @method Show\Field|Collection check_result_uuid(string $label = null)
     * @method Show\Field|Collection question(string $label = null)
     * @method Show\Field|Collection rectify(string $label = null)
     * @method Show\Field|Collection check_standard_id(string $label = null)
     * @method Show\Field|Collection check_question_id(string $label = null)
     * @method Show\Field|Collection firm_id(string $label = null)
     * @method Show\Field|Collection report_code(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection check_result(string $label = null)
     * @method Show\Field|Collection total_point(string $label = null)
     * @method Show\Field|Collection deduction_point(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection file_name(string $label = null)
     * @method Show\Field|Collection file_path(string $label = null)
     * @method Show\Field|Collection file_extension(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection system_item_id(string $label = null)
     * @method Show\Field|Collection community_name(string $label = null)
     * @method Show\Field|Collection custom_number(string $label = null)
     * @method Show\Field|Collection head_man(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection floor(string $label = null)
     * @method Show\Field|Collection area_quantity(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection pictures(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection expires_at(string $label = null)
     * @method Show\Field|Collection area_id(string $label = null)
     * @method Show\Field|Collection check_unit(string $label = null)
     * @method Show\Field|Collection notification_title(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection job_info(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
