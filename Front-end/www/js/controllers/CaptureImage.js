angular.module('CaptureImage.controllers', [])

.controller('captureImageCtrl', function($scope, $cordovaCamera, $ionicModal, $q) {

    function createNewModal() {
        var deferred = $q.defer();
        if ($scope.modal) {
            $scope.modal.remove();
            delete $scope.modal;
            $crop_img.cropper('destroy');
        }
        $ionicModal.fromTemplateUrl('templates/cropImage.html', {
            scope: $scope
        }).then(function(modal) {
            $scope.modal = modal;

            deferred.resolve();
        });
        return deferred.promise;

    }

    // Open the modal
    $scope.openCropModal = function(imageBLOB) {
        createNewModal().then(function() {
            $scope.modal.show();
            var canvas = document.getElementById('myCanvas');
            if (canvas) canvas.remove();
            canvas = document.createElement('canvas');
            canvas.id = 'myCanvas';
            $('#canvas_container').append(canvas);
            canvas.width = 500;
            canvas.height = 500;
            var context = canvas.getContext('2d');
            var imageObj = new Image();
            imageObj.src = "data:image/jpeg;base64," + imageBLOB;
            imageObj.onload = function() {
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
                init_crop_methods();

            };
        })

    };

    function init_crop_methods() {
        var $crop_img = $('.container > canvas');
        $crop_img.cropper('destroy');
        $crop_img.cropper({
            background: false,
            modal: true,
            built: function() {
                setTimeout(function() {
                    $crop_img.cropper('rotate', 90)
                }, 0)
            }
        });

        $scope.crop = function() {

            var res = $crop_img.cropper('getCroppedCanvas');
            if (ionic.Platform.isAndroid()) {
                //save to album
                window.canvas2ImagePlugin.saveImageDataToLibrary(
                    function(data) {
                        $scope.$parent.capturedImagePath = data;

                        
                    },
                    function(err) {
                        alert('err');
                    },
                    res
                );
            }
            $crop_img.cropper('destroy');
            $scope.modal.hide();
            $scope.$parent.receipt.image = res.toDataURL();
            
            $scope.modal.remove();
        }
        $scope.rotate = function() {

            $crop_img.cropper('rotate', 90)
        }

    }
    $scope.takePicture = function() {
        var options = {
            quality: 70,
            destinationType: Camera.DestinationType.DATA_URL,
            sourceType: Camera.PictureSourceType.CAMERA,
            allowEdit: false,
            encodingType: Camera.EncodingType.JPEG,
            popoverOptions: CameraPopoverOptions,
            saveToPhotoAlbum: true
        };
        setTimeout(function() {
            $cordovaCamera.getPicture(options)
                .then($scope.openCropModal, function(err) {});
        }, 500)

    }
})