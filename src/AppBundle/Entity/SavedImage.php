<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SavedImage
 * @ORM\Table(name="saved_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SavedImageRepository")
 */
class SavedImage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="date")
     */
    private $updatedAt;



    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $originalImage;

    /**
     * @return mixed
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }

    /**
     * @param mixed $originalImage
     */
    public function setOriginalImage($originalImage)
    {
        $this->originalImage = $originalImage;
    }




    public function setFile(UploadedFile $file )
    {
        $this->file = $file;
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var File
     * @Assert\Image(
     *      maxSize = "1024k",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *      })
     */
    private $file;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return SavedImage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return SavedImage
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this->filename;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }



    public function upload()
    {
        if ($this->file === null){return;}
        $this->filename =$this->file->getClientOriginalName();



        $this->file->move($this->getUploadRoot(),$this->getFilename());
        $this->file=null;
    }


    public  function getUploadDir()
    {
        return 'uploads/images/saved-images';
    }
    public function getWebPath()
    {

        return $this->getUploadDir().'/'.$this->filename;
    }
    public function getAbsoluteRoot()
    {
        return getUploadRoot().$this->filename;
    }


    public function getUploadRoot()
    {

        return __DIR__.'/../../../web/'.$this->getUploadDir().'/';

    }

    function __toString()
    {
        return $this->name;
    }



}

