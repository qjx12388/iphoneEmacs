;; ggtags config
(add-to-list 'load-path "~/.emacs.d/elpa/ggtags-20150129.46")
(add-to-list 'load-path "~/.emacs.d/elpa/cl-lib-0.5")
(require 'cl-lib)
(require 'ggtags)

(add-hook 'c-mode-common-hook
          (lambda ()
            (when (derived-mode-p 'c-mode 'c++-mode 'java-mode 'objc-mode)
              (ggtags-mode 1))))


(provide 'init-ggtags)
