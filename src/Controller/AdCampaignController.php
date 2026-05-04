<?php

namespace App\Controller;

use App\Repository\AdCampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\AdCampaign;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class AdCampaignController extends AbstractController
{
    #[Route('/api/ad-campaigns', name: 'app_ad_campaigns_index', methods: ['GET'])]
public function index(AdCampaignRepository $adCampaignRepository): JsonResponse
{
    $campaigns = $adCampaignRepository->findAll();

    $data = [];

    foreach ($campaigns as $campaign) {
        $data[] = [
            'id' => $campaign->getId(),
            'name' => $campaign->getName(),
            'budget' => $campaign->getBudget(),
            'status' => $campaign->getStatus(),
        ];
    }

    return $this->json($data);
}

#[Route('/api/ad-campaigns', name: 'app_ad_campaigns_create', methods: ['POST'])]
public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $errors = [];

    if (empty($data['name'])) {
        $errors[] = 'Name is required';
    }

    if (!isset($data['budget']) || $data['budget'] < 0) {
        $errors[] = 'Budget must be positive';
    }

    if (empty($data['status'])) {
        $errors[] = 'Status is required';
    }

    if (!empty($errors)) {
        return $this->json([
            'errors' => $errors
        ], 400);
    }

    $campaign = new AdCampaign();
    $campaign->setName($data['name']);
    $campaign->setBudget($data['budget']);
    $campaign->setStatus($data['status']);
    $campaign->setCreatedAt(new \DateTimeImmutable());

    $entityManager->persist($campaign);
    $entityManager->flush();

    return $this->json([
        'message' => 'Campaign created successfully',
        'id' => $campaign->getId()
    ], 201);
}

#[Route('/api/ad-campaigns/{id}', name: 'app_ad_campaigns_show', methods: ['GET'])]
public function show(int $id, AdCampaignRepository $adCampaignRepository): JsonResponse
{
    $campaign = $adCampaignRepository->find($id);

    if (!$campaign) {
        return $this->json([
            'message' => 'Campaign not found'
        ], 404);
    }

    return $this->json([
        'id' => $campaign->getId(),
        'name' => $campaign->getName(),
        'budget' => $campaign->getBudget(),
        'status' => $campaign->getStatus(),
    ]);
}

#[Route('/api/ad-campaigns/{id}', name: 'app_ad_campaigns_update', methods: ['PUT'])]
public function update(int $id, Request $request, AdCampaignRepository $adCampaignRepository, EntityManagerInterface $entityManager): JsonResponse
{
    $campaign = $adCampaignRepository->find($id);

    if (!$campaign) {
        return $this->json([
            'message' => 'Campaign not found'
        ], 404);
    }

    $data = json_decode($request->getContent(), true);

    $errors = [];

    if (isset($data['name']) && empty($data['name'])) {
        $errors[] = 'Name cannot be empty';
    }

    if (isset($data['budget']) && $data['budget'] < 0) {
        $errors[] = 'Budget must be positive';
    }

    if (isset($data['status']) && empty($data['status'])) {
        $errors[] = 'Status cannot be empty';
    }

    if (!empty($errors)) {
        return $this->json([
            'errors' => $errors
        ], 400);
    }

    if (isset($data['name'])) {
        $campaign->setName($data['name']);
    }

    if (isset($data['budget'])) {
        $campaign->setBudget($data['budget']);
    }

    if (isset($data['status'])) {
        $campaign->setStatus($data['status']);
    }

    if (method_exists($campaign, 'setUpdatedAt')) {
        $campaign->setUpdatedAt(new \DateTimeImmutable());
    }

    $entityManager->flush();

    return $this->json([
        'message' => 'Campaign updated successfully'
    ]);
}
    #[Route('/api/ad-campaigns/{id}', name: 'app_ad_campaigns_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        AdCampaignRepository $adCampaignRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $campaign = $adCampaignRepository->find($id);

        if (!$campaign) {
            return $this->json([
                'message' => 'Campaign not found'
            ], 404);
        }

        $entityManager->remove($campaign);
        $entityManager->flush();

        return $this->json([
            'message' => 'Campaign deleted successfully'
        ]);
    }
}




