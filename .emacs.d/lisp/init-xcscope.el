;;xcscope config
(add-to-list 'load-path "~/.emacs.d/elpa/xcscope-20140510.1437")
(require 'xcscope)

(cscope-setup)
(setq cscope-initial-directory "~/work/ios/apple/hebtp")

;;(add-hook 'objc-mode-hook 'cscope-minor-mode)
;;(setq cscope-program "gtags-cscope")
(provide 'init-xcscope)
