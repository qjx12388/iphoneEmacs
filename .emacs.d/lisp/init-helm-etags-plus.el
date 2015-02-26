;;helm-etags+.el config
(add-to-list 'load-path "~/.emacs.d/elpa/helm-etags-plus")

;;helm-etags-plus require
(add-to-list 'load-path "~/.emacs.d/elpa/helm-20150224.2232")

;;helm require
(add-to-list 'load-path "~/.emacs.d/elpa/cl-lib-0.5")
(add-to-list 'load-path "~/.emacs.d/elpa/async-20150203.2127")
(require 'helm-etags+)

(provide 'init-helm-etags-plus)
