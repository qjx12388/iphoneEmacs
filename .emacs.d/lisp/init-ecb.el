;;ecb config
(add-to-list 'load-path "~/.emacs.d/elpa/ecb")
(load-file "~/.emacs.d/elpa/ecb/ecb.el")

(require 'ecb)

;;(require 'ecb-autoloads)


;;不显示每日提示
(setq ecb-tip-of-the-day nil)
(setq stack-trace-on-error t)
(provide 'init-ecb)
