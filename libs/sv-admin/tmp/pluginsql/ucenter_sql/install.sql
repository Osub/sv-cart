INSERT INTO `svcart_operator_actions` (`id`, `level`, `parent_id`, `code`, `status`, `orderby`, `created`, `modified`) VALUES
(211, 0, 210, 'ucenter_view', '1', 50, '2009-06-18 14:30:46', '2009-06-18 14:30:46'),
(210, 0, 0, 'ucenter_mgt', '1', 50, '2009-06-18 14:30:02', '2009-06-18 14:30:02');

INSERT INTO `svcart_operator_action_i18ns` (`id`, `locale`, `operator_action_id`, `name`, `operator_action_values`, `description`, `created`, `modified`) VALUES
(994, 'eng', 211, 'ucenter整合查看', '', '', '2009-06-18 14:30:46', '2009-06-18 14:30:46'),
(993, 'chi', 211, 'ucenter整合查看', '', '', '2009-06-18 14:30:46', '2009-06-18 14:30:46'),
(992, 'eng', 210, 'ucenter整合', '', '', '2009-06-18 14:30:02', '2009-06-18 14:30:02'),
(991, 'chi', 210, 'ucenter整合', '', '', '2009-06-18 14:30:02', '2009-06-18 14:30:02');
