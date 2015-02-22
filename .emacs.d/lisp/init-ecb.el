;;ecb config
(add-to-list 'load-path "~/.emacs.d/elpa/ecb-2.40")

(require 'ecb)
;;不显示每日提示
(setq ecb-tip-of-the-day nil)
(setq stack-trace-on-error t)
(provide 'init-ecb)
