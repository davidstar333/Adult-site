ALTER TABLE `users`
MODIFY COLUMN `gender` enum('male','female','transgender') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `passwordResetToken`;

ALTER TABLE `performer`
MODIFY COLUMN `sex` enum('male','female','transgender') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `user_id`;
